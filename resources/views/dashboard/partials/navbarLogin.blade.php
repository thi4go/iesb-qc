
<?php
if(session()->has('user')){

    $firstName = explode(' ', session()->get('user')->name);
    $firstName = ucfirst($firstName[0]);

    $url       = session()->get('user')->avatar;

    $avatar =  $url;

} else {
    $firstName = "";
    $avatar = "";
}
?>

<nav-bar-vue
        avatar="{{$avatar}}"
        name="{{$firstName}}"
        tabs='[ {"name": "Vantagens", "url": "/#features7-5"},
                {"name": "Contato", "url": "/#contatos"},
                {"name": "Blog", "url": "@lang('urls.blog')"}]'
></nav-bar-vue>
