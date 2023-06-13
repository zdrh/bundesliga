<?php
namespace App\Libraries;

class ArrayLib {

    function __construct() {

    }
    /**
     * @param pole  - pole objektů, ze kterého budu vybírat
     * @param key - název atributu, který bude tvřit klíč dropdownu (<option value=>)
     * @param value - název atributu, který se bude psát mezi options nebo pole atributů
     * @param default - 0 znamená, že žádná hodnota nebude defaultně vybraná, 1 - bude dopředu vybraná hodnota
     */
    function dataForDropdown($pole, $key, $value, $blank = true, $delimiter = '', $default = 0) {
        $result = array();
        if($blank) {
            $result[''] = '---vyber si možnost ---';
        }
        
        foreach ($pole as $row) {
            if(is_array($value)) {
                $res = '';
                foreach($value as $val) {
                    $res .= $row->$val.$delimiter;
                }
                $res = substr($res, 0, -1);
                $result[$row->$key] = $res;
            } else {
                $result[$row->$key] = $row->$value; 
            }
            
        }
        if(!$default) {
            
        }

        return $result;
    }
    /**
     * @param main - hlavní pole, ze kterého budu vybírat (pole pro data s dropdownem)
     * @param compared - pole, které budu porovnávat, při shodě klíče s hlavním polem, tak klíč přidám do výsledku jako hodnotu výsledného pole
     * @param extra - pole, kde jsou navíc klíče, které mají být ve výsledku - které přidám
     * @param remove - klíč, který odebrat z výsledku (např. při editaci aktuální záznam ponechám)
     */
    function addExtraForDropdown(array $main, array $compared, array $extra = array(), array $remove = array()) {
        $result = $extra;
        foreach($compared as $key => $value) {
            if(array_key_exists($key, $main)) {
                $result[] = $key;
            }
        }
        foreach($remove as $row) {
            $key = array_search($row, $result);
            if($key !== false) {
                unset($result[$key]);
            }
        }

        return $result;
    }

    /**
     * odebere z pole ty klíče, které mají jsou stejné jako nějaká hodnota v poli remove
     */
    function removeFromArray($array,  $remove) {

        
        $result = array();
        
            foreach($array as $key => $row) {
                
                $subResult = true;
                foreach($remove as $value) {
                    if($key == $value){
                        $subResult = false;
                    }
                }
                if($subResult) {
                    $result[$key] = $row;
                }
            }

            return $result;
        }
/**
 * vytvoří pole objektů z daného prvku linky, vloží je do nové atributu
 * @param arrayList - to, co budeme procházet, musí se jednat o pole objektů nebo objekt
 * @param attribut - který atribut budeme upravvoat na linky
 * @param newAttribut - název nového atributu, do kterého dáme nové linky
 * @param array - jestli se jedná o pole nebo o objekt, true je pole, false objekt
 */
        function links($arrayList, $attribut, $newAttribut, $array = true) {
            $result = array();
            if(!$array) {
                $prvek = $arrayList->$attribut;
                $novyPrvek = $this->makeLink($prvek);
                $arrayList->$newAttribut = $novyPrvek;
                $result = $arrayList;
            } else {
                foreach ($arrayList as $row) {
                    $prvek = $row->$attribut;
                
                    $novyPrvek = $this->makeLink($prvek);
                    $row->$newAttribut = $novyPrvek;
                    $result[] = $row;
                    }
                }
            return $result;
        }
/**
 * převede text do formátu linků - nahradí písmena s háčky apod na písmena bez háčků, mezery nahradí pomlčkami
 */
        private function makeLink($text) {
            
            $text = mb_strtolower($text, 'UTF-8');
            
            $search = array('ä', 'ö', 'ü', 'ß', ' ');
            $replace = array('a', 'o', 'u', 'ss', '-');
            $result = str_replace($search, $replace, $text, $i);
            return $result;
        }
    /**
     * otestuje dvourozměrné pole, jestli v každém vnitřním poli je počet prvků roven count, vrátí true nebo false
     */
        function testArray($array, $count) {
            $result = true;
            foreach($array as $row) {
                $pocet = Count($row);
                if($pocet != $count) {
                    $result = false;
                }   
            }

            return $result;
        }
        /**
         * spojí v poli $array prvky $column1 a $column2 do nového prvku $newColumn, oddělovačem mezi column1 a column2 bude $delimiter
         */
       function implodeArray($array, $column1, $column2, $delimiter, $newColumn) {
            $result = array();
            foreach($array as $row) {
                $new = $row->$column1.$delimiter.$row->$column2;
                $new2 = $row;
                $new2->$newColumn = $new;
                $result[] = $new2;

            }

            return $result;

        }
        /**
         * do mainroArray přidá prvky, které se týkají společného sloupce
         */
        function insertArrayIntoAnotherArray($maiorArray, $minorArray, $columnMaior, $columnMinor, $newColumn) {
            $result = array();
            foreach ($maiorArray as $row) {
                $grouped = $row->$columnMaior;
                $smallArray = array();
                foreach($minorArray as $row2) {
                    
                    if($grouped == $row2->$columnMinor) {
                        $smallArray[] = $row2;
                    }
                    
                }
                $row->$newColumn = $smallArray;
                $result[] = $row;
            }

            return $result;


        }
    }