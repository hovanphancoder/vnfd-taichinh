<div class="row">
    <div class="col-md-12">
        <div class="page-box">
            <div class="pagination-example">
                <nav aria-label="Page navigation" class="navi">
                    <ul class="pagination">
                        <li>
                            <a href="{!!$paginator->url(1)!!}" aria-label="Previous">
                                <i class="fa fa-angle-double-left"></i>
                            </a>
                        </li>
                        <?php
                        for ($i = 1; $i <= $paginator->lastPage(); $i++) {
                            ?>
                            <li class="{!!($paginator->currentPage() == $i)?'active':''!!}"><a href="{!!$paginator->url($i)!!}">{!!$i!!}</a></li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="{!!$paginator->url($paginator->currentPage()+1)!!}" aria-label="Next">
                                <i class="fa fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>