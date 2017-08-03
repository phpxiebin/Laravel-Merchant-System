<nav class="navbar navbar-static-top" role="navigation">
    <div class="navbar-header">
        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                class="navbar-toggle collapsed" type="button">
            <i class="fa fa-reorder"></i>
        </button>
        <a href="{{ url('merchant') }}" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <div class="navbar-collapse collapse" id="navbar">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a aria-expanded="false" role="button" href="javascript:void(0);" class="dropdown-toggle"
                   data-toggle="dropdown">人脸信息管理<span class="caret"></span></a>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="{{ url('merchant/face') }}">人脸数据管理</a></li>
                    <li><a href="{{ url('merchant/group') }}">组数据管理</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="{{ url('merchant/auth/logout') }}">
                    <i class="fa fa-sign-out"></i> 退出
                </a>
            </li>
        </ul>
    </div>
</nav>