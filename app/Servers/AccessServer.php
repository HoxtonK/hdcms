<?php

namespace App\Servers;

use App\Models\Module;
use App\Models\Site;
use Spatie\Permission\Models\Permission;

/**
 * 站点模块权限服务
 * Class Access
 * @package App\Servers
 */
class AccessServer
{
  /**
   * 获取站点权限列表
   * @param Site $site
   * 
   * @return array
   */
  public function getSiteAccess(Site $site)
  {
    $permissions = Permission::where('site_id', $site['id'])->get();

    return $permissions->map(function ($p) {
      $p['module_name'] = Module::find($p['module_id'])['title'];
      return $p;
    })->groupBy('module_name');
  }

  /**
   * 更新所有站点权限
   * @return void
   */
  public function updateAllSitePermission()
  {
    foreach (Site::all() as $site)
      $this->updateSitePermission($site);
  }

  /**
   * 更新所有模块权限
   * @param Site $site
   * 
   * @return void
   */
  public function updateSitePermission(Site $site)
  {
    foreach (Module::get() as $module) {
      $this->removeInvalidModulePermission($module, $site);
      $this->addModulePermissionToSite($module, $site);
    }

    app()['cache']->forget('spatie.permission.cache');
  }

  /**
   * 移除无效的模块权限
   * @param Module $module
   * @param Site $site
   * 
   * @return mixed
   */
  protected function removeInvalidModulePermission(Module $module, Site $site)
  {
    $moduleConfig = app(ModuleServer::class)->getModuleInfo($module['name']);
    $permissions = $site->permissions()->where('module_id', $module['id'])->get();

    $permissions->map(function ($permission) use ($moduleConfig, $site, $module) {
      foreach ($moduleConfig['permissions'] as $p) {
        if ($permission['name'] == ($this->prefix($site, $module) . $p['name']))
          return true;
      }
      $permission->delete();
    });
  }

  /**
   * 设置模块在网站的权限
   * @param Module $module
   * @param Site $site
   * 
   * @return void
   */
  protected function addModulePermissionToSite(Module $module, Site $site)
  {
    $moduleConfig = app(ModuleServer::class)->getModuleInfo($module['name']);

    foreach ($moduleConfig['permissions'] as $permission) {
      //如果权限标识已经存在时不添加
      $name = $this->prefix($site, $module) . $permission['name'];
      $hasPermission = $site->permissions()->where('name', $name)->first();

      if (!$hasPermission) {
        Permission::create([
          'name' =>  $name,
          'title' => $permission['title'],
          'site_id' => $site['id'],
          'module_id' => $module['id'],
          'guard_name' => 'web'
        ]);
      }
    }
  }

  /**
   * 权限标识前缀
   * @param Site $site
   * @param Module $module
   * 
   * @return string
   */
  protected function prefix(Site $site, Module $module)
  {
    return "S{$site['id']}-{$module['name']}-";
  }
}
