<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 微信公众号资料
 * @package App\Models
 */
class WeChat extends BaseModel
{
  protected $fillable = ['site_id', 'title', 'name', 'introduce', 'qr', 'token', 'type', 'wechat_id', 'appID', 'appsecret', 'welcome', 'default_message'];

  protected $casts = [
    'menus' => 'array',
  ];

  /**
   * 粉丝
   * @return HasMany
   */
  public function users()
  {
    return $this->hasMany(WeChatUser::class, 'wechat_id');
  }
}
