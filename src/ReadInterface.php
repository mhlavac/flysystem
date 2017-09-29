<?php

namespace League\Flysystem;

interface ReadInterface
{
    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|bool|null
     */
    public function has($path);

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function read($path);

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function readStream($path);

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false);

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function getMetadata($path);

    /**
     * Get the size of a file.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function getSize($path);

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function getMimetype($path);

    /**
     * Get the timestamp of a file.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function getTimestamp($path);

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @throws AdapterException    If a low-level, adapter-specific error occurs
     *                             (disk full, permission denied, network error, ...)
     *
     * @return array|false
     */
    public function getVisibility($path);
}
