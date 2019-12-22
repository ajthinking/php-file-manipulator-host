<?php

namespace App\PSRManipulator;

/**
 * This interface serves merely as documentation on the public PSRFile API
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
     * @return void
     */
    public function classMethods();

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