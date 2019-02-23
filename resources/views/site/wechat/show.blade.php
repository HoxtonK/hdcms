@extends('layouts.admin')
@section('content')
    <div class="alert alert-info" role="alert">
        <strong>您绑定的微信公众号：<strong class="text-danger">{{$wechat['name']}}</strong>，请按照下列引导完成配置。</strong>
    </div>

    <div class="card">
        <div class="card-header">
            登录 <a href="https://mp.weixin.qq.com/" target="_blank">微信公众平台</a>，点击左侧菜单最后一项，进入 [ 开发者中心 ]
        </div>
        <div class="card-body">
            <img src="{{asset('wechat/Snip20160308_5.png')}}" alt="">
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            在开发者中心，找到［ 服务器配置 ］栏目下URL和Token设置
        </div>
        <div class="card-body">
            <img src="{{asset('wechat/2.png')}}">
            <hr>
            <span class="text-secondary">将以下链接链接填入对应输入框</span>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label text-right">URL</label>
                <div class="col-sm-10">
                    <a href="javascript:void(0);" class="form-control-plaintext text-primary copy"
                       data-clipboard-text="{{route('api.weChat',$site)}}">
                        {{route('api.weChat',$site)}}
                    </a>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label text-right">Token</label>
                <div class="col-sm-10">
                    <a href="javascript:void(0);" readonly class="form-control-plaintext text-primary copy"
                       data-clipboard-text="{{$wechat['token']}}">
                        {{$wechat['token']}}
                    </a>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label text-right">EncodingAESKey</label>
                <div class="col-sm-10">
                    <a href="javascript:void(0);" readonly class="form-control-plaintext text-primary copy"
                       data-clipboard-text="{{$wechat['EncodingAESKey']}}">
                        {{$wechat['EncodingAESKey']}}
                    </a>
                </div>
            </div>
            @push('js')
                <script>
                    require(['hdjs'], function (hdjs) {
                        hdjs.clipboard('.copy',{},function(e){
                            hdjs.notify('复制成功');
                            e.clearSelection();
                        })
                    });
                </script>
                @endpush
        </div>
    </div>
    <div class="alert alert-success mt-3">
       配置好微信后， 发送关键词 <strong>hdcms</strong> 检查配置状态吧
    </div>
@stop