<?php
$header = json_decode($header->config);
$social = json_decode($social->config);
$footer = json_decode($footer->config);
//dd($header->logo);
?>
<!-- Header 
============================================= -->
<header id="home">

    <!-- Start Navigation -->
    <nav class="navbar navbar-default attr-border navbar-sticky bootsnav">
        <!-- Start Top Search -->
            <div class="container">
                <div class="row">
                    <div class="top-search">
                        <div class="input-group">
                            <form >
                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search">
                                <button type="button" id="btn_search" onclick="jRedirect('<?php echo url('search');?>')" >
                                    <i class="fas fa-search"></i>
                                </button>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Top Search -->
        <div class="container">

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                </ul>
            </div>        
            <!-- End Atribute Navigation -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{!! url('/') !!}">
                    <img  src="{!! url('images/upload/'.$header->logo) !!}" class="logo" alt="Logo">
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                    <?php
                        function categoryTree($parent_id = 0, $submark = '') {
                           // DB::enableQueryLog();
                           $select=[
                                'menu_language.title',
                                'menu_language.link',
                                'menu.id',
                                'menu.parent_id'
                           ];
                      //     $id_catemenu, $language, $parent_id = 0,$select = []){
                            $query = App\Menu::getParentMenu(3,get_id_locale(Session()->get('locale')), $parent_id,$select);
                            //$queries = DB::getQueryLog();
                         //print_r($queries);
                         //    dd($query);
                         
                            if ($query) {
                                foreach ($query as $count => $catepost) {
                                    ?>
                                    <li class="<?php echo $submark.' ';?><?php echo ($catepost->parent_id == 0 || App\Menu::checkHasChild($catepost->id)=='yes')?'dropdown':''?>">
                                        <a href="{!! url($catepost->link) !!}" <?php echo ($catepost->parent_id != 0 || App\Menu::checkHasChild($catepost->id)=='yes')?'class="dropdown-toggle" data-toggle="dropdown"':''?> ><?php echo $catepost->title?>
                                        <?php #echo ($catepost->parent_id == 0)?'<i class="fa fa-angle-right"></i>':''?>
                                        </a>
                                        <?php
                                        // if($catepost->parent_id == 0){
                                            ?>
                                            <ul class="dropdown-menu" role="menu">
                                                <?php
                                                    categoryTree($catepost->id, $submark);
                                                ?>
                                            </ul>
                                            <?php
                                        // }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        echo categoryTree();
                    ?>
                    <li class="language-icon"><a href="{!! url('language/vi') !!}"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAFsSURBVHjaYvzPgAD/UNlYEUAAmuTYAAAQhAEYqF/zFbe50RZ1cMmS9TLi0pJLRjZohAMTGFUN9HdnHgEE1sDw//+Tp0ClINW/f4NI9d////3+f+b3/1+////+9f/XL6A4o6ws0AaAAGIBm/0fRTVQ2v3Pf97f/4/9Aqv+DdHA8Ps3UANAALEAMSNQNdDGP3+ALvnf8vv/t9//9X/////7f+uv/4K//iciNABNBwggsJP+/IW4kuH3n//1v/8v+wVSDURmv/57//7/CeokoKFA0wECiAnkpL9/wH4CO+DNr/+VQA1A9PN/w6//j36CVIMRxEkAAQR20m+QpSBXgU0CuSTj9/93v/8v//V/xW+48UBD/zAwAAQQSAMzOMiABoBUswCd8ev/M7A669//OX7///Lr/x+gBlCoAJ0DEEAgDUy//zBISoKNAfoepJNRFmQkyJecfxj4/kDCEIiAigECiPErakTiiWMIAAgwAB4ZUlqMMhQQAAAAAElFTkSuQmCC"></a></li>
                    <li class="language-icon"><a href="{!! url('language/en') !!}"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAflJREFUeNpinDRzn5qN3uFDt16+YWBg+Pv339+KGN0rbVP+//2rW5tf0Hfy/2+mr99+yKpyOl3Ydt8njEWIn8f9zj639NC7j78eP//8739GVUUhNUNuhl8//ysKeZrJ/v7z10Zb2PTQTIY1XZO2Xmfad+f7XgkXxuUrVB6cjPVXef78JyMjA8PFuwyX7gAZj97+T2e9o3d4BWNp84K1NzubTjAB3fH0+fv6N3qP/ir9bW6ozNQCijB8/8zw/TuQ7r4/ndvN5mZgkpPXiis3Pv34+ZPh5t23//79Rwehof/9/NDEgMrOXHvJcrllgpoRN8PFOwy/fzP8+gUlgZI/f/5xcPj/69e/37//AUX+/mXRkN555gsOG2xt/5hZQMwF4r9///75++f3nz8nr75gSms82jfvQnT6zqvXPjC8e/srJQHo9P9fvwNtAHmG4f8zZ6dDc3bIyM2LTNlsbtfM9OPHH3FhtqUz3eXX9H+cOy9ZMB2o6t/Pn0DHMPz/b+2wXGTvPlPGFxdcD+mZyjP8+8MUE6sa7a/xo6Pykn1s4zdzIZ6///8zMGpKM2pKAB0jqy4UE7/msKat6Jw5mafrsxNtWZ6/fjvNLW29qv25pQd///n+5+/fxDDVbcc//P/zx/36m5Ub9zL8+7t66yEROcHK7q5bldMBAgwADcRBCuVLfoEAAAAASUVORK5CYII="></a></li>
                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

    </nav>
    <!-- End Navigation -->

</header>
<!-- End Header -->