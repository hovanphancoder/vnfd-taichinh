<ul class="list-unstyled components">
    <?php
    if (Auth::user()->id == 6) {
    ?>
        <li>
            <a href="#banner" data-toggle="collapse" aria-expanded="false"> <i class="fa fa-image"></i> Banner </a>
            <ul <?php echo (Route::currentRouteName()=="listbanner" || Route::currentRouteName()=="viewbanner" || Route::currentRouteName()=="addbanner" || Route::currentRouteName()=="createbanner" ) ? 'class="list-unstyled collapse in" id="banner" aria-expanded="true"' : 'class="collapse list-unstyled" id="banner"'; ?>>
                <li <?php echo (Route::currentRouteName()=="listbanner" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/banner/list')!!}">Banner</a></li>
                <li <?php echo (Route::currentRouteName()=="addbanner" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/banner/add')!!}">Create banner</a></li>
            </ul>
        </li>
        <li data-sort="2"> <a href="#createproduct" <?php echo (Route::currentRouteName()=="listproduct" || Route::currentRouteName()=="viewproduct" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>            <i class="fa fa-file-text-o"></i>            Product        </a>
            <ul <?php echo (Route::currentRouteName()=="listproduct" || Route::currentRouteName()=="viewproduct" || Route::currentRouteName()=="addproduct" || Route::currentRouteName()=="cateproduct" || Route::currentRouteName()=="viewcateproduct" || Route::currentRouteName()=="addcateproduct" || Route::currentRouteName()=="trademarkproduct" || Route::currentRouteName()=="addtrademark" || Route::currentRouteName()=="viewtrademark" || Route::currentRouteName()=="optionlist" || Route::currentRouteName()=="viewoption" || Route::currentRouteName()=="addoption" || Route::currentRouteName()=="grouplist" || Route::currentRouteName()=="viewgroupproduct" || Route::currentRouteName()=="addgroupporduct" ) ? 'class="list-unstyled collapse in" id="createpost" aria-expanded="true"' : 'class="collapse list-unstyled" id="createproduct"'; ?>>
                <li <?php echo (Route::currentRouteName()=="listproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/list')!!}">All product</a></li>
                <li <?php echo (Route::currentRouteName()=="addproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/add')!!}">Add product</a></li>
                <li <?php echo (Route::currentRouteName()=="cateproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/category')!!}">All category</a></li>
                <li <?php echo (Route::currentRouteName()=="addcateproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/categoryproduct/add')!!}">Add category</a></li>
				<!--<li <?php echo (Route::currentRouteName()=="grouplist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/group')!!}">Group</a></li>
                <li <?php echo (Route::currentRouteName()=="trademarkproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/trademark')!!}">Trademark</a></li>-->
                <li <?php echo (Route::currentRouteName()=="optionlist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/option')!!}">Option</a></li>
				
            </ul>
        </li>
        <li data-sort="2"> <a href="#createorder" <?php echo (Route::currentRouteName()=="orderlist" || Route::currentRouteName()=="orderview" || Route::currentRouteName()=="orderadd" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>            <i class="fa fa-file-text-o"></i>            Order        </a>
            <ul <?php echo (Route::currentRouteName()=="orderlist" || Route::currentRouteName()=="orderview" || Route::currentRouteName()=="orderadd" ) ? 'class="list-unstyled collapse in" id="createorder" aria-expanded="true"' : 'class="collapse list-unstyled" id="createorder"'; ?>>
                <li <?php echo (Route::currentRouteName()=="orderlist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/order/list')!!}">All order</a></li>
				<li <?php echo (Route::currentRouteName()=="orderadd" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/order/add')!!}">Add order</a></li>
            </ul>
        </li>
        <li> <a href="#createcustomer" <?php echo (Route::currentRouteName()=="listcustomer" || Route::currentRouteName()=="viewcustomer" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>            <i class="fa fa-image"></i> Customer        </a>
            <ul <?php echo (Route::currentRouteName()=="listcustomer" || Route::currentRouteName()=="addcustomer" || Route::currentRouteName()=="viewcustomer" || Route::currentRouteName()=="importcustomer") ? 'class="list-unstyled collapse in" id="createcustomer" aria-expanded="true"' : 'class="collapse list-unstyled" id="createcustomer"'; ?>>
                <li <?php echo (Route::currentRouteName()=="listcustomer" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/customer/list')!!}">All Customer</a></li>
                <li <?php echo (Route::currentRouteName()=="addcustomer" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/customer/add')!!}">Create a Customer</a></li>
				<!-- <li <?php echo (Route::currentRouteName()=="importcustomer" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/customer/import')!!}">Import Customer</a></li> -->
            </ul>
        </li>
        <li <?php echo (Route::currentRouteName()=="listnewsletter" || Route::currentRouteName()=="viewnewsletter" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/newsletter/list')!!}"><i class="ti-view-list-alt"></i> Newsletter</a></li>
    <?php
    }else{    
    ?>
            <li data-sort="1">
                <a href="{!!url('admin/dashboard')!!}">
                    <i class="fa fa-dashboard"></i> Dashboard

                </a>
            </li>
            <li data-sort="2">
                <a href="#createpost" <?php echo (Route::currentRouteName()=="post" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
            <i class="fa fa-file-text-o"></i>
            Post
                </a>
                <ul <?php echo (Route::currentRouteName()=="addcollectionpost" || Route::currentRouteName()=="viewcollectionpost" || Route::currentRouteName()=="listcollectionpost" || Route::currentRouteName()=="addpost" || Route::currentRouteName()=="addcategorypost" || Route::currentRouteName()=="listcategorypost" || Route::currentRouteName()=="listpost" || Route::currentRouteName()=="editpost" || Route::currentRouteName()=="viewpost" ) ? 'class="list-unstyled collapse in" id="createpost" aria-expanded="true"' : 'class="collapse list-unstyled" id="createpost"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="listpost" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/post/list')!!}">All post</a></li>
                    <li <?php echo (Route::currentRouteName()=="addpost" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/post/add')!!}">Create a post</a></li>
                    <li <?php echo (Route::currentRouteName()=="listcategorypost" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/post/listcategorypost')!!}">Category</a></li>
                    <li <?php echo (Route::currentRouteName()=="addcategorypost" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/post/addcategorypost')!!}">Create a Category</a></li>
                </ul>
            </li>

            <li data-sort="2">
                <a href="#createproduct" <?php echo (Route::currentRouteName()=="listproduct" || Route::currentRouteName()=="viewproduct" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>><i class="fa fa-file-text-o"></i>Product</a>
                <ul <?php echo (Route::currentRouteName()=="listproduct" || Route::currentRouteName()=="viewproduct" || Route::currentRouteName()=="addproduct" || Route::currentRouteName()=="cateproduct" || Route::currentRouteName()=="viewcateproduct" || Route::currentRouteName()=="addcateproduct" || Route::currentRouteName()=="trademarkproduct" || Route::currentRouteName()=="addtrademark" || Route::currentRouteName()=="viewtrademark" || Route::currentRouteName()=="optionlist" || Route::currentRouteName()=="viewoption" || Route::currentRouteName()=="addoption" || Route::currentRouteName()=="addoption" || Route::currentRouteName()=="grouplist" || Route::currentRouteName()=="viewgroupproduct" || Route::currentRouteName()=="addgroupporduct" ) ? 'class="list-unstyled collapse in" id="createpost" aria-expanded="true"' : 'class="collapse list-unstyled" id="createproduct"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="listproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/list')!!}">All product</a></li>
                    <li <?php echo (Route::currentRouteName()=="addproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/add')!!}">Add product</a></li>
                    <li <?php echo (Route::currentRouteName()=="cateproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/category')!!}">All category</a></li>
                    <li <?php echo (Route::currentRouteName()=="addcateproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/categoryproduct/add')!!}">Add category</a></li>
					<!--<li <?php echo (Route::currentRouteName()=="grouplist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/group')!!}">Group</a></li>
                    <li <?php echo (Route::currentRouteName()=="trademarkproduct" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/trademark')!!}">Trademark</a></li>-->
                    <li <?php echo (Route::currentRouteName()=="optionlist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/product/option')!!}">Option</a></li>
					
                </ul>
            </li>

            <li data-sort="2">
                <a href="#createorder" <?php echo (Route::currentRouteName()=="orderlist" || Route::currentRouteName()=="orderview" || Route::currentRouteName()=="orderadd" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
            <i class="fa fa-file-text-o"></i>
            Order
        </a>
                <ul <?php echo (Route::currentRouteName()=="orderlist" || Route::currentRouteName()=="orderview" || Route::currentRouteName()=="orderadd" ) ? 'class="list-unstyled collapse in" id="createorder" aria-expanded="true"' : 'class="collapse list-unstyled" id="createorder"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="orderlist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/order/list')!!}">All order</a></li>
					<li <?php echo (Route::currentRouteName()=="orderadd" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/order/add')!!}">Add order</a></li>
                </ul>
            </li>

            <li data-sort="3">
                    <a href="#page" data-toggle="collapse" aria-expanded="false">
                        <i class="fa fa-file"></i> Page
                    </a>
                    <ul <?php echo (Route::currentRouteName()=="viewpage" || Route::currentRouteName()=="addpage" || Route::currentRouteName()=="listpage" ) ? 'class="list-unstyled collapse in" id="page" aria-expanded="true"' : 'class="collapse list-unstyled" id="page"'; ?>>
                        <li <?php echo (Route::currentRouteName()=="listpage" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/page/list')!!}">All page</a></li>
                        <li <?php echo (Route::currentRouteName()=="addpage" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/page/add')!!}">Create Page</a></li>
                    </ul>
                </li>
                <li <?php echo (Route::currentRouteName()=="listcourse" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/consultant/list')!!}"><i class="ti-view-list-alt"></i> Register cousultant</a></li>
                <li <?php echo (Route::currentRouteName()=="listcontact" || Route::currentRouteName()=="viewcontact" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/contact/list')!!}"><i class="ti-view-list-alt"></i> Contact</a></li>

            <li>
                <a href="#banner" data-toggle="collapse" aria-expanded="false">
                    <i class="fa fa-image"></i> Banner
                </a>
                <ul <?php echo (Route::currentRouteName()=="listbanner" || Route::currentRouteName()=="viewbanner" || Route::currentRouteName()=="addbanner" || Route::currentRouteName()=="createbanner" ) ? 'class="list-unstyled collapse in" id="banner" aria-expanded="true"' : 'class="collapse list-unstyled" id="banner"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="listbanner" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/banner/list')!!}">Banner</a></li>
                    <li <?php echo (Route::currentRouteName()=="addbanner" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/banner/add')!!}">Create banner</a></li>
                </ul>
            </li>
            <li <?php echo (Route::currentRouteName()=="filemanager" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/filemanage/filemanager')!!}"><i class="fa fa-file"></i> File Manager</a></li>
            <li>
                <a href="#createcoupon" <?php echo (Route::currentRouteName()=="listcoupon" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
                    <i class="fa fa-image"></i> Coupon
                </a>
                <ul <?php echo (Route::currentRouteName()=="listcoupon" || Route::currentRouteName()=="coupon.show" || Route::currentRouteName()=="editcoupon" || Route::currentRouteName()=="addcoupon" ) ? 'class="list-unstyled collapse in" id="createscreen" aria-expanded="true"' : 'class="collapse list-unstyled" id="createcoupon"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="listcoupon" || Route::currentRouteName()=="coupon.show" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/coupon/list')!!}">All coupon</a></li>
                    <li <?php echo (Route::currentRouteName()=="addcoupon" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/coupon/add')!!}">Create a coupon</a></li>
                </ul>
            </li>
            <li>
                <a href="#createcustomer" <?php echo (Route::currentRouteName()=="listcustomer" || Route::currentRouteName()=="viewcustomer" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
            <i class="fa fa-image"></i> Customer
        </a>
                <ul <?php echo (Route::currentRouteName()=="listcustomer" || Route::currentRouteName()=="addcustomer" || Route::currentRouteName()=="viewcustomer" || Route::currentRouteName()=="importcustomer") ? 'class="list-unstyled collapse in" id="createcustomer" aria-expanded="true"' : 'class="collapse list-unstyled" id="createcustomer"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="listcustomer" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/customer/list')!!}">All Customer</a></li>
                    <li <?php echo (Route::currentRouteName()=="addcustomer" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/customer/add')!!}">Create a Customer</a></li>
					<!-- <li <?php echo (Route::currentRouteName()=="importcustomer" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/customer/import')!!}">Import Customer</a></li> -->
                </ul>
            </li>
            <li>
                <a href="#createvideo" <?php echo (Route::currentRouteName()=="listvideo" || Route::currentRouteName()=="viewvideo" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
                    <i class="fa fa-image"></i> video
                </a>
                <ul <?php echo (Route::currentRouteName()=="listvideo" || Route::currentRouteName()=="addvideo" || Route::currentRouteName()=="viewvideo") ? 'class="list-unstyled collapse in" id="createvideo" aria-expanded="true"' : 'class="collapse list-unstyled" id="createvideo"'; ?>>
                    <li <?php echo (Route::currentRouteName()=="listvideo" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/video/list')!!}">All video</a></li>
                    <li <?php echo (Route::currentRouteName()=="addvideo" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/video/add')!!}">Create a video</a></li>
                </ul>
            </li>
            <li <?php echo (Route::currentRouteName()=="listsection" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/section/list')!!}"><i class="fa fa-circle-o-notch"></i> Section page</a></li>
            
            <li>
                <a href="#menu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-bars"></i> Menu</a>
                <ul <?php echo (Route::currentRouteName()=="listmenu" || Route::currentRouteName()=="catemenu" || Route::currentRouteName()=="addmenu" || Route::currentRouteName()=="detailmenu" ) ? 'class="list-unstyled collapse in" aria-expanded="true"' : 'class="collapse list-unstyled"'; ?> id="menu">
                    <li <?php echo (Route::currentRouteName()=="listmenu" || Route::currentRouteName()=="catemenu" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/menu/list')!!}">Menus</a></li>
                    <li <?php echo (Route::currentRouteName()=="addmenu" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/menu/add')!!}">Create a Menu</a></li>
                </ul>
            </li>
            <li>
                    <a href="#setting" <?php echo (Route::currentRouteName()=="mail" || Route::currentRouteName()=="advertising" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
                <i class="ti-settings"></i>
                Setting
            </a>
                    <ul <?php echo (Route::currentRouteName()=="mail" || Route::currentRouteName()=="advertising" || Route::currentRouteName()=="frontend" ) ? 'class="list-unstyled collapse in" aria-expanded="true"' : 'class="collapse list-unstyled"'; ?> id="setting">
                        <li <?php echo (Route::currentRouteName()=="frontend" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/setting/frontend')!!}">Front End</a></li>
                        <li <?php echo (Route::currentRouteName()=="mail" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/setting/mail')!!}">Mail</a></li>
                        <li <?php echo (Route::currentRouteName()=="advertising" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/setting/advertising')!!}">Advertising</a></li>
                    </ul>
                </li>
            <?php
    if (Auth::user()->group_id === 1) {
        ?>
                <li data-sort="3">
                    <a href="#page" data-toggle="collapse" aria-expanded="false">
                        <i class="fa fa-file"></i> Page
                    </a>
                    <ul <?php echo (Route::currentRouteName()=="viewpage" || Route::currentRouteName()=="addpage" || Route::currentRouteName()=="listpage" ) ? 'class="list-unstyled collapse in" id="page" aria-expanded="true"' : 'class="collapse list-unstyled" id="page"'; ?>>
                        <li <?php echo (Route::currentRouteName()=="listpage" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/page/list')!!}">All page</a></li>
                        <li <?php echo (Route::currentRouteName()=="addpage" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/page/add')!!}">Create Page</a></li>
                    </ul>
                </li>
                <li <?php echo (Route::currentRouteName()=="listcourse" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/consultant/list')!!}"><i class="ti-view-list-alt"></i> Register consultant</a></li>
                <li <?php echo (Route::currentRouteName()=="listcontact" || Route::currentRouteName()=="viewcontact" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/contact/list')!!}"><i class="ti-view-list-alt"></i> Contact</a></li>
                <li <?php echo (Route::currentRouteName()=="listnewsletter" || Route::currentRouteName()=="viewnewsletter" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/newsletter/list')!!}"><i class="ti-view-list-alt"></i> Newsletter</a></li>
                <li>
					<a href="#gallery" data-toggle="collapse" aria-expanded="false">
						<i class="fa fa-image"></i> Gallery
					</a>
					<ul <?php echo (Route::currentRouteName()=="viewgallery" || Route::currentRouteName()=="addgallery" || Route::currentRouteName()=="listgallery" ) ? 'class="list-unstyled collapse in" id="gallery" aria-expanded="true"' : 'class="collapse list-unstyled" id="gallery"'; ?>>
						<li <?php echo (Route::currentRouteName()=="listgallery" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/gallery/list')!!}">All gallery</a></li>
						<li <?php echo (Route::currentRouteName()=="addgallery" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/gallery/add')!!}">Create Gallery</a></li>
					</ul>
				</li>
				<li>
                    <a href="#user" <?php echo (Route::currentRouteName()=="profile" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
                <i class="fa fa-user"></i>
                User
            </a>
                    <ul <?php echo (Route::currentRouteName()=="userlist" || Route::currentRouteName()=="useradd" ) ? 'class="list-unstyled collapse in" aria-expanded="true"' : 'class="collapse list-unstyled"'; ?> id="user">
                        <li <?php echo (Route::currentRouteName()=="userlist" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/user/list')!!}">List</a></li>
                        <li <?php echo (Route::currentRouteName()=="useradd" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/user/add')!!}">Create a User</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#setting" <?php echo (Route::currentRouteName()=="mail" || Route::currentRouteName()=="advertising" ) ? 'data-toggle="collapse" aria-expanded="true"' : 'data-toggle="collapse" aria-expanded="false"'; ?>>
                <i class="ti-settings"></i>
                Setting
            </a>
                    <ul <?php echo (Route::currentRouteName()=="mail" || Route::currentRouteName()=="advertising" || Route::currentRouteName()=="frontend" ) ? 'class="list-unstyled collapse in" aria-expanded="true"' : 'class="collapse list-unstyled"'; ?> id="setting">
                        <li <?php echo (Route::currentRouteName()=="frontend" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/setting/frontend')!!}">Front End</a></li>
                        <li <?php echo (Route::currentRouteName()=="mail" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/setting/mail')!!}">Mail</a></li>
                        <li <?php echo (Route::currentRouteName()=="advertising" ) ? 'class="active"' : "" ?>><a href="{!!url('admin/setting/advertising')!!}">Advertising</a></li>
                    </ul>
                </li>
                <?php
    }	}
    ?>
</ul>
@section('assetjs')
<script>
    $.noConflict();
    jQuery(document).ready(function() {

    });
</script>
@endsection