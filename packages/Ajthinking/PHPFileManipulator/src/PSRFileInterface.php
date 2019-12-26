<?php

namespace Ajthinking\PHPFileManipulator;

/**
 * -----------------------------------------------------------------------
 * This interface serves merely as documentation on the public PSRFile API
 * 
 * ------------------------------------------------------------------------
 * Each PSRFile instance exposes the following resources
 * namespace
 * useStatements
 * className
 * classExtends
 * classImplements
 * traits
 * properties
 * methods
 * 
 * ------------------------------------------------------------------------
 * API conventions used where applicable
 * Fetch values:        $file->__KEY__()
 * Overwrite values:    $file->__KEY__($values)
 * Add values:          $file->add__KEY__($values)
 * Remove values        $file->remove__KEY__($values)
 * 
 * ------------------------------------------------------------------------
 * Other public methods
 * load, print, preview, save as documented below 
 * 
 * ------------------------------------------------------------------------
 */
interface PSRFileInterface {
    /**
     * Create a new PSRFile instance
     *
     * @param string $relativePath
     * @return PSRFile
     */
    static public function load($relativePath);

    /**
     * Get the associated path of the file
     *
     * @return string
     */
    public function path();

    /**
     * Get the content of the file
     *
     * @return string
     */
    public function contents();

    /**
     * Get or set the namespace of the file
     *
     * @param string $newNamespace
     * @return string
     */
    public function namespace($newNamespace = false);

    /**
     * Undocumented function
     *
     * @param boolean $newUseStatements
     * @return void
     */
    public function useStatements($newUseStatements = false);

    /**
     * Undocumented function
     *
     * @param boolean $newClassName
     * @return void
     */
    public function className($newClassName = false);

    /**
     * Undocumented function
     *
     * @param boolean $path
     * @return void
     */
    public function save($path = false);

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ast(); 

    /**
     * Undocumented function
     *
     * @return void
     */
    public function parse();

    /**
     * Undocumented function
     *
     * @return void
     */
    public function print();    
}