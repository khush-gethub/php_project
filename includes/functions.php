<?php

// Array of random avatar URLs to be used in avatar.php
$avatar_urls = [
    'https://i.pinimg.com/1200x/68/e4/24/68e42428134581259d464896ac826b2b.jpg',
    'https://i.pinimg.com/736x/67/e0/f4/67e0f43a5795f412139477c0e85e7dd7.jpg',
    'https://i.pinimg.com/736x/5e/44/db/5e44db92fea8441b4c0377ec77664ed0.jpg',
    'https://i.pinimg.com/1200x/d2/81/41/d28141ea9b14869db9dc4cdbb27a5132.jpg',
    'https://i.pinimg.com/736x/90/68/7f/90687fdb3e09f2518e6c4799eb3a0668.jpg',
    'https://i.pinimg.com/736x/6a/0d/91/6a0d91751d01d300da30e85d418493b0.jpg'
];

// Function to assign random avatar
function getRandomAvatar()
{
    global $avatar_urls;
    return $avatar_urls[array_rand($avatar_urls)];
}
?>