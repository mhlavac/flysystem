<?php
/**
 * throwing an exception in all cases when something goes wrong on the underlying storage based on
 * https://github.com/thephpleague/flysystem/issues/620
 *
 * PHP Version 7
 *
 * @author    Viorena Cerenishti <vcerenishti@wayfair.com>
 * @copyright 2017 Wayfair LLC - All rights reserved
 */

namespace League\Flysystem;


class AdapterException extends \Exception {
  /**
   * @param \Exception $e Exception thrown from adapter
   *
   * @return \League\Flysystem\AdapterException
   */
  public static function wrap(\Exception $e) {
    return new self($e->getMessage(), $e->getCode(), $e);
  }
}