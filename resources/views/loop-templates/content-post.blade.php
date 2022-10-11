@php
  $post = isset($post) ? $post : get_post(get_the_ID());
@endphp

<article class="d-flex flex-column {{ $class ?? 'gap-2' }}" id="post-<?php $post->ID; ?>">

  <div class="entry-image">
    <a href="{{ the_permalink($post->ID) }}">
      @if($thumbnail = get_the_post_thumbnail($post->ID, 'full', ['class' => 'w-100 object-cover rounded', 'style' => 'height: auto;']))
        {!! $thumbnail !!}  
      @endif
    </a>
  </div>

  <div class="entry-content d-flex justify-content-center flex-column">

    <header class="entry-header">

      <!-- Output first category -->
      @php 
        $category = get_the_category($post->ID); 
        $post_link = get_the_permalink($post->ID);
      @endphp

      @if($category)
        @php  
          $category_link = get_category_link($category[0]->term_id);
          $category_name = $category[0]->name;
        @endphp
        <a href="{{ $category_link }}" class="text-decoration-underline text-primary d-block pb-1">
          {!! $category_name !!}
        </a>
      @endif
      
      <h3 class='entry-title fs-2 mb-1'><a class='text-decoration-none' href='<?= $post_link ?>'>{{ get_the_title($post->ID); }}</a></h3>

    </header><!-- .entry-header -->

    <!-- Limit words to 20 -->
    @php
      if($post->post_excerpt) {
        $snippet = wp_trim_words($post->post_excerpt, 20);
      } else {
        $snippet = wp_trim_words($post->post_content, 20);
      }
    @endphp
    {!! $snippet !!}
    <footer class='article-footer mt-1'>
      <a href="{{ the_permalink($post->ID) }}" class="btn btn-primary">
        {{ __('Read More', 'buildystrap-parent') }}
      </a>
    </footer>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
