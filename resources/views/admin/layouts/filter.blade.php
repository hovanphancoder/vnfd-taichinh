<?php
//echo Request::get('id_cate');
?>
<section class="content-header">
    <div class="content-header-left">
        <div class="">
        <a href="{!!url('admin/post/list')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
        <a href="{!!url('admin/post/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
        </div>
    </div>
    <div class="content-header-right">
        <div class="seipkon-breadcromb-right-no">
            <form action="{!!action('Admin\PostController@searchPostCate')!!}" method="POST">
                <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                <ul>
                    <li>
                        <div class="">
                            <select class="form-control" id="category" name="id_cate" onchange="return window.location.href = 'list?id_cate='+ $(this).val(); ">
                                <option value="0">Category</option>
                                <?php
                                function categoryTree($parent_id = 0, $submark = '') {
                                    $query = App\Categorypost::getListCategoryParent($parent_id);
                                    if ($query) {
                                        foreach ($query as $catepost) {
                                            ?>
                                            <option <?php if ($catepost->id == Request::input('id_cate')) echo "selected" ?> value="{!!$catepost->id!!}"><?php echo $submark . $catepost->title ?></option>
                                            <?php
                                            categoryTree($catepost->id, $submark . '---- ');
                                        }
                                    }
                                }
                                echo categoryTree();
                                ?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="">
                            <input class="form-control" placeholder="Keyword" id="text-field" type="text" name="keyword" value="<?php echo (Request::isMethod('POST') ? Request::input('keyword') : ""); ?>">
                        </div>
                    </li>
                    <li>
                        <div class="">
                            <button type="submit" class="btn btn-default">Search</button>
                            <a class="btn btn-default" href="{!!url('admin/post/list')!!}">Reset</a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</section>
