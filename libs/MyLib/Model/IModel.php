<?php

interface IModel {

    /**
     * @desc connects to the database
     */
    function connect();

    /**
     * basic insert of array $data to the table, returns new id
     * @param array $args
     * @param $table
     * @return integer
     */
    function insert(array $args, $table = null);

    /**
     * retrieve specific record according to column = value or returns all items if no argument presented
     * @param $value
     * @param $column
     * @param $context
     * @param $table
     * @return mixed
     */
    function find($value = null, $column = 'id', $context = 'i', $table = null);

    /**
     * @desc returns DibiDataSource of given parameters
     * @param mixes $value
     * @param string $column
     * @param string $context
     * @param string $table
     * @return DibiDataSource
     */
    function dataSource($value = null, $column = 'id', $context = 'i', $table = null);

    /**
     * deletes specified record from table
     * @param $id
     * @param $table
     * @return unknown_type
     */
    function delete($id, $table = null);

    /**
     * record exist? true : false
     * @param $value
     * @param $col
     * @param $context
     * @return boolean
     */
    function exists($value, $col = 'id', $context = 'i', $table = null);

    /**
     * updates record according to given $args (must include id)
     * @param $args
     * @param $table
     * @return unknown_type
     */
    function update(array $args, $table = null);
}
