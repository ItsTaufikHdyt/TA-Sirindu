<div class="left-side-bar">
	<div class="brand-logo">
		<a href="#">
			<img src="{{asset('logo/spkgizi-white.png')}}" width="70" height="70" class="light-logo">
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				
				@if (Auth::user()->type == 'admin')
				<li>
					<a href="{{Route('admin.home')}}" class="dropdown-toggle no-arrow">
						<span class="micon fa fa-home"></span><span class="mtext">Home</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon fa fa-database"></span><span class="mtext">Data</span>
					</a>
					<ul class="submenu">
						<li><a href="{{route('admin.anak')}}">Data Anak</a></li>
						<li><a href="{{route('admin.fuzzy')}}">Data Himpunan Fuzzy</a></li>
					</ul>
				</li>
				<li>
					<a href="{{Route('admin.user')}}" class="dropdown-toggle no-arrow">
						<span class="micon fa fa-user"></span><span class="mtext">User</span>
					</a>
				</li>
				@elseif(Auth::user()->type == 'opd')
				<li>
					<a href="{{Route('opd.home')}}" class="dropdown-toggle no-arrow">
						<span class="micon fa fa-home"></span><span class="mtext">Home</span>
					</a>
				</li>
				<li>
					<a href="{{Route('opd.anak')}}" class="dropdown-toggle no-arrow">
						<span class="micon fa fa-user"></span><span class="mtext">Data Anak</span>
					</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</div>
<div class="mobile-menu-overlay"></div>