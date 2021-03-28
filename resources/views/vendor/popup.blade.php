<?php
?>
@if($getpopup)
<div class="popup" style="display: none;">
    <div class="pop-up-overlay"></div>
    <div class="popup-content">
        <div class="content-image">
            <a href="javascript:void(0)">
                <img src="{!!url('images/upload/bannerslides/'.$getpopup->image)!!}" alt="{!!$getpopup->title_vn!!}">
            </a>
        </div>
        <button class="popup-close" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 22.6 22.6" style="height: 1em; width: 1em;" xml:space="preserve" preserveAspectRatio="none"><rect fill="currentColor" x="8.3" y="-1.7" transform="matrix(0.7071 0.7071 -0.7071 0.7071 11.3137 -4.6863)" width="6" height="26"></rect><rect fill="currentColor" x="8.3" y="-1.7" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 27.3137 11.3137)" width="6" height="26"></rect></svg>
        </button>
    </div>
</div>
@endif