<?php
// echo "<pre>";
// print_r($getCategory);
// exit;
?>
<!-- META -->

@if($status_page == 1)
<link rel="alternate" hreflang="vi" href="{!! ($metaPage->slug == 'trang-chu')?url('/'):url($metaPage->slug) !!}" />
<link rel="canonical" href="{!! ($metaPage->slug == 'trang-chu')?url('/'):url($metaPage->slug) !!}" />
<meta name="description" content="{!! $metaPage->description !!}">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{!! $metaPage->title !!}" />
<meta property="og:description" content="{!! $metaPage->description !!}" />
<meta property="og:url" content="{!! ($metaPage->slug == 'trang-chu')?url('/'):url($metaPage->slug) !!}" />
<meta property="og:site_name" content="{!! $metaPage->title !!}" />
<meta property="og:image" content="{!! url('images/upload/page/'.$metaPage->image) !!}" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="{!! $metaPage->title !!}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{!! $metaPage->title !!}" />
<meta name="twitter:image" content="{!! url('images/upload/page/'.$metaPage->image) !!}" />

@elseif($status_page == 2)
<link rel="alternate" hreflang="vi" href="{!! ($metaPage->slug == 'trang-chu')?url('/'):url($metaPage->slug) !!}" />
<link rel="canonical" href="{!! ($metaPage->slug == 'trang-chu')?url('/'):url($metaPage->slug) !!}" />
<meta name="description" content="{!! $metaPage->description !!}">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{!! $metaPage->title !!}" />
<meta property="og:description" content="{!! $metaPage->description !!}" />
<meta property="og:url" content="{!! ($metaPage->slug == 'trang-chu')?url('/'):url($metaPage->slug) !!}" />
<meta property="og:site_name" content="{!! $metaPage->title !!}" />
<meta property="og:image" content="{!! url('images/upload/page/'.$metaPage->image) !!}" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="{!! $metaPage->title !!}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{!! $metaPage->title !!}" />
<meta name="twitter:image" content="{!! url('images/upload/page/'.$metaPage->image) !!}" />
@elseif($status_page == 3)
<link rel="alternate" hreflang="vi" href="{!! url($getCategory->slug) !!}" />
<link rel="canonical" href="{!! url($getCategory->slug) !!}" />
<meta name="description" content="{!! $getCategory->description !!}">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{!! $getCategory->title !!}" />
<meta property="og:description" content="{!! $getCategory->description !!}" />
<meta property="og:url" content="{!! url($getCategory->slug) !!}" />
<meta property="og:site_name" content="{!! $getCategory->title !!}" />
<meta property="og:image" content="{!! url('images/upload/post/'.$getCategory->image) !!}" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="{!! $getCategory->title !!}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{!! $getCategory->title !!}" />
<meta name="twitter:image" content="{!! url('images/upload/post/'.$getCategory->image) !!}" />
@elseif($status_page == 4)
<link rel="alternate" hreflang="vi" href="{!! url($cateSlug.'/'.$post->slug) !!}" />
<link rel="canonical" href="{!! url($cateSlug.'/'.$post->slug) !!}" />
<meta name="description" content="{!! $post->description !!}">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{!! $post->title !!}" />
<meta property="og:description" content="{!! $post->description !!}" />
<meta property="og:url" content="{!! url($cateSlug.'/'.$post->slug) !!}" />
<meta property="og:site_name" content="{!! $post->title !!}" />
<meta property="og:image" content="{!! url('images/upload/post/'.$post->image) !!}" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="{!! $post->title !!}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{!! $post->title !!}" />
<meta name="twitter:image" content="{!! url('images/upload/post/'.$post->image) !!}" />
@elseif($status_page == 5)
<link rel="alternate" hreflang="vi" href="{{ url()->current() }}" />
<link rel="canonical" href="{{ url()->current() }}" />
<meta name="description" content="{!! $post->description !!}">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{!! $post->title !!}" />
<meta property="og:description" content="{!! $post->description !!}" />
<meta property="og:url" content="{!! url($post->slug) !!}" />
<meta property="og:site_name" content="{!! $post->title !!}" />
<meta property="og:image" content="{!! url('images/upload/post/'.$post->image) !!}" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="{!! $post->title !!}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{!! $post->title !!}" />
<meta name="twitter:image" content="{!! url('images/upload/post/'.$post->image) !!}" />
@elseif($status_page == "category_post")
<link rel="alternate" hreflang="vi" href="" />
<link rel="canonical" href="" />
<meta name="description" content="">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="" />
<meta property="og:description" content="" />
<meta property="og:url" content="" />
<meta property="og:site_name" content="" />
<meta property="og:image" content="" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="" />
<meta name="twitter:image" content="" />
@else
<link rel="alternate" hreflang="vi" href="{!! url('tag/'.$getTag->slug) !!}" />
<link rel="canonical" href="{!! url('tag/'.$getTag->slug) !!}" />
<meta name="description" content="{!! $getTag->description !!}">
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{!! $getTag->name !!}" />
<meta property="og:description" content="{!! $getTag->description !!}" />
<meta property="og:url" content="{!! url('tag/'.$getTag->slug) !!}" />
<meta property="og:site_name" content="{!! $getTag->name !!}" />
<meta property="og:image" content="{!! url('images/upload/tag/'.$getTag->image) !!}" />
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="450" />
<meta property="og:image:alt" content="{!! $getTag->name !!}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{!! $getTag->name !!}" />
<meta name="twitter:image" content="{!! url('images/upload/tag/'.$getTag->image) !!}" />
@endif
