@props(['post', 'class' => ''])

<x-card 
  :post="$post"
  :permalink="get_permalink( $post->ID )" 
  :media="get_the_post_thumbnail($post->ID, 'post-card', ['class' => 'w-100 h-100 object-cover post-card-image'])" 
  :content="wp_trim_words($post->post_content, 25)"
  :title="$post->post_title"
  :class="$class"
  >
  @slot('beforeTitle')
    <div class="post_meta d-flex align-items-center gap-2 mb-2">
      <div class="post-author d-flex align-items-center gap-1">
        <img src="{{ get_avatar_url($post->post_author) }}" alt="{{ get_the_author_meta('display_name', $post->post_author) }}" class="avatar rounded-circle" style="width: 4.3rem; aspect-ratio: 1/1;">
        <span class="post_author">{{ get_the_author_meta('display_name', $post->post_author) }}</span>
      </div>
      <span class="post_date">{{ get_the_date('F j, Y', $post->ID) }}</span>
    </div>
  @endslot
</x-card>