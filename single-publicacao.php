<?php

global $post;

wp_redirect( site_url( "/publicacoes?pub_id={$post->ID}" ) );