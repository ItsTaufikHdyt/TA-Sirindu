<div class="left-side-bar">
	<div class="brand-logo">
		<a href="#">
			<!-- <img src="{{asset('logo/Sirindu-white.png')}}" alt="" class="light-logo"> -->
			{{-- <img src="{{asset('logo/Sirindu-allblack.png')}}" alt="" class="dark-logo">
			<img src="{{asset('logo/Sirindu-white.png')}}" alt="" class="light-logo"> --}}
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				@if (Auth::user()->type == 'super-admin')
				<li>
					<a href="{{Route('super.admin.home')}}" class="dropdown-toggle no-arrow">
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
				@elseif (Auth::user()->type == 'admin')
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
				@endif
				@if (Auth::user()->type == 'super-admin')
				<li>
					<a href="{{Route('super.admin.user')}}" class="dropdown-toggle no-arrow">
						<span class="micon fa fa-user"></span><span class="mtext">User</span>
					</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</div>
<div class="mobile-menu-overlay"></div>