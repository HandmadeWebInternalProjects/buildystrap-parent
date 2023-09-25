<?php

namespace Buildystrap;

class BSLogger
{
  // Create variable to save status of debugging
  public static $debugging = false;

  // instance
  private static $instance;

  private function __construct()
  {
    // Check if debugging is enabled
    if (bs_get_field('buildystrap_debug_enable_debugging', 'option')) {
      // Set debugging to true
      self::$debugging = true;
    }
  }

  // Get the instance of the class
  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  // Log to the WordPress debug log
  public static function log($message, $context)
  {
    // Check if debugging is enabled
    if (!self::$debugging) {
      // Debugging is not enabled, return
      return;
    }

    // Check if the message is an array or object
    if (is_array($message) || is_object($message)) {
      // Convert the message to a string
      $message = print_r($message, true);
    }

    // Check if the context is an array or object
    if (is_array($context) || is_object($context)) {
      // Convert the context to a string
      $context = print_r($context, true);
    }

    // Log the message and context to the WordPress debug log
    error_log($message . ' ' . $context);
  }
}
