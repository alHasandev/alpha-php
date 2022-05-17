<?php

session_start();

if ($page !== 'auth') {
  if (isset($_SESSION['auth'])) {
    $auth = $_SESSION['auth'];
  } else {
    header('location: ' . page('auth', 'logout'));
  }
} else {
  if (isset($_SESSION['auth'])) {
    redirect('home');
  }
}
