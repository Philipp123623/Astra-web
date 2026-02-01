<?php
session_start();

/**
 * Verfügbare Sprachen
 */
$availableLangs = ['de', 'en', 'fr', 'es'];

/**
 * 1. Sprache per URL (?lang=fr)
 */
if (isset($_GET['lang']) && in_array($_GET['lang'], $availableLangs)) {
    $_SESSION['lang'] = $_GET['lang'];
}

/**
 * 2. Session
 */
$lang = $_SESSION['lang'] ?? 'de';

/**
 * 3. Fallback
 */
if (!in_array($lang, $availableLangs)) {
    $lang = 'de';
}

/**
 * Sprachdatei laden
 */
$t = require $_SERVER['DOCUMENT_ROOT'] . "/lang/$lang.php";
