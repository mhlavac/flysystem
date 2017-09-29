<?php
/**
 * PHP Version 7
 *
 * Extends Local Class to overrida and throw exceptions AdapterException on php errors
 *
 * @author    Viorena Cerenishti <vcerenishti@wayfair.com>
 * @copyright 2017 Wayfair LLC - All rights reserved
 */

namespace League\Flysystem\Adapter;

use League\Flysystem\AdapterException;
use LogicException;
use League\Flysystem\Config;

class LocalAdapter extends Local {

  /**
   * LocalAdapter constructor.
   *
   * @param string $root         path of root directory
   * @param int    $writeFlags   write flags
   * @param int    $linkHandling link handling
   * @param array  $permissions  array permissions
   */
  public function __construct(
      $root,
      $writeFlags = LOCK_EX,
      $linkHandling = self::DISALLOW_LINKS,
      array $permissions = []
  ) {
    parent::__construct($root, $writeFlags, $linkHandling, $permissions);
  }

  /**
   * @param string                   $path     file path
   * @param string                   $contents file content
   * @param \League\Flysystem\Config $config   Config object
   *
   * @return array
   * @throws AdapterException
   */
  public function write($path, $contents, Config $config) {
    $root = $this->getPathPrefix();

    if ( !is_dir($root) || !is_writable($root)) {
      throw new LogicException('The root path ' . $root . ' is not writable.');
    }

    $location = $this->applyPathPrefix($path);
    $this->ensureDirectory(dirname($location));

    if ( !@file_put_contents($location, $contents, $this->writeFlags)) {
      $error = error_get_last();
      throw new AdapterException($error['message'] . ' File ' . $error['file'] . ' Line ' . $error['line']);
    }

    $type = 'file';
    $result = compact('contents', 'type', 'size', 'path');

    if ($visibility = $config->get('visibility')) {
      $result['visibility'] = $visibility;
      $this->setVisibility($path, $visibility);
    }

    return $result;
  }

  /**
   * @param string $path file path
   *
   * @return array
   * @throws AdapterException
   */
  public function read($path) {
    $location = $this->applyPathPrefix($path);
    $contents = @file_get_contents($location);

    if ($contents === false) {
      $error = error_get_last();
      throw new AdapterException($error['message'] . ' File ' . $error['file'] . ' Line ' . $error['line']);
    }

    return ['type' => 'file', 'path' => $path, 'contents' => $contents];
  }

}