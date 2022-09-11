<?php
#Jozef Makiš

ini_set('display_errors', 'stderr');
/*
 * Testovacia trieda pre interpret.py a parse.php
 */
class testPhp
{
    private $find_args_po = false;
    private $find_args_io = false;
    private $find_args_rec = false;

    private $find_args_dir = NULL;
    private $dir_bool = false;

    private $find_args_ps = "parse.php";
    private $ps_bool = false;

    private $find_args_is = "interpret.py";
    private $is_bool = false;

    private $find_args_jf = "/pub/courses/ipp/jexamxml/jexamxml.jar";
    private $jf_bool = false;

    private $find_args_jc = "/pub/courses/ipp/jexamxml/options";
    private $jc_bool = false;

    /*
     * Premenné pre štastistiky a výsledky testov.
     */
    private $test_ok = 0;
    private $test_fail = 0;

    private $test_inter_ok = 0;
    private $test_inter_fail = 0;

    private $test_fail_name_pars = array();
    private $test_ok_name_pars = array();

    private $test_fail_name_inter  = array();
    private $test_ok_name_inter = array();

    /*
     * Metoda spracováva parametre príkzovej riadky a naásledne podla parametrov testuje zadané skripty.
     */
    public function pars_arg_test($argv)
    {
        $this->find_args_dir = getcwd();
        $arg_count = count($argv);
        for ($iter = 0; $iter < $arg_count; $iter++) {
            if (preg_match("/^--directory=.+$/", $argv[$iter])) {
                $this->dir_bool = true;
                $this->find_args_dir = $argv[$iter];
                continue;
            }
            if (preg_match("/^--recursive$/", $argv[$iter])) {
                $this->find_args_rec = true;
                continue;
            }
            if (preg_match("/^--parse-script=.+$/", $argv[$iter])) {
                $this->ps_bool = true;
                $this->find_args_ps = $argv[$iter];
                continue;
            }
            if (preg_match("/^--int-script=.+$/", $argv[$iter])) {
                $this->is_bool = true;
                $this->find_args_is = $argv[$iter];
                continue;
            }
            if (preg_match("/^--parse-only$/", $argv[$iter])) {
                $this->find_args_po = true;
                continue;
            }
            if (preg_match("/^--int-only$/", $argv[$iter])) {
                $this->find_args_io = true;
                continue;
            }
            if (preg_match("/^--jexamxml=.+$/", $argv[$iter])) {
                $this->jf_bool = true;
                $this->find_args_jf = $argv[$iter];
                continue;
            }
            if (preg_match("/^--jexamcfg=.+$/", $argv[$iter])) {
                $this->jc_bool = true;
                $this->find_args_jc = $argv[$iter];
                continue;
            }
            if ($iter == 1) {
                if ($argv[1] == "--help") {
                    echo "Použitie: php7.4 test.php parametry\n";
                    echo "Základne parametry: --help pre vypis nápovedy,\n
           --directory=path adresar s testami, príklad : --directory=tests/pushFrame/,\n
           --recursive pre rekurzivne prehladavanie v adresari,\n
           --parse-script=file pripadna cesta ku parsovaciemu skriptu ak sa nenachadza v aktualnom adresari,\n
           --int-script=file pripadna cesta ku interpretu ak sa nenachadza v aktualnom adresari,\n
           --parse-only bude testovaný iba skrit pre parser,\n
           --int-only bude testovaný iba interpret,\n
           --jexamxml=file súbor s JAR balíčkom s A7Soft JExamXML, ak je vynechaný testuje sa umiestnenie na server melin, príklad --jexamxml=JExamXML/jexamxml.jar\n
           --jexamcfg=file súbor s konfiguráciou A7Soft JExamXML, príklad --jexamcfg=JExamXML/options.\n";
                    exit(0);
                }
            }
        }

        if (isset($this->find_args_dir)) {
            if ($this->dir_bool) {
                $this->find_args_dir = explode("=", $this->find_args_dir);
                $this->find_args_dir = $this->find_args_dir[1];

                if (!file_exists($this->find_args_dir)) {
                    fwrite(STDERR, "Zadaný adresár neexistuje 1!\n");
                    exit(41);
                }
            }
            if (!file_exists($this->find_args_dir)) {
                fwrite(STDERR, "Zadaný adresár neexistuje 2!\n");
                exit(41);
            }
        } else {
            fwrite(STDERR, "Zadaný adresár neexistuje 3!\n");
            exit(41);
        }
        if (isset($this->find_args_ps)) {
            if ($this->ps_bool) {
                $this->find_args_ps = explode("=", $this->find_args_ps);
                $this->find_args_ps = $this->find_args_ps[1];

                if (!file_exists($this->find_args_ps)) {
                    fwrite(STDERR, "Zadaný adresár neexistuje 4!\n");
                    exit(41);
                }
            }
            if (!file_exists($this->find_args_ps)) {
                fwrite(STDERR, "Zadaný adresár neexistuje 5!\n");
                exit(41);
            }
        } else {
            fwrite(STDERR, "Zadaný adresár neexistuje 6!\n");
            exit(41);
        }
        if (isset($this->find_args_is) && !isset($this->find_args_po)) {
            if ($this->is_bool) {
                $this->find_args_is = explode("=", $this->find_args_is);
                $this->find_args_is = $this->find_args_is[1];

                if (!file_exists($this->find_args_is)) {
                    fwrite(STDERR, "Zadaný adresár neexistuje 7!\n");
                    exit(41);
                }
            }
            if (!file_exists($this->find_args_is)) {
                fwrite(STDERR, "Zadaný adresár neexistuje 8!\n");
                exit(41);
            }
        }
        if (isset($this->find_args_jf)) {
            if ($this->jf_bool) {
                $this->find_args_jf = explode("=", $this->find_args_jf);
                $this->find_args_jf = $this->find_args_jf[1];

                if (!file_exists($this->find_args_jf)) {
                    fwrite(STDERR, "Zadaný adresár neexistuje 10!\n");
                    exit(41);
                }
            }
            if (!file_exists($this->find_args_jf)) {
                fwrite(STDERR, "Zadaný adresár neexistuje 11!\n");
                exit(41);
            }
        } else {
            fwrite(STDERR, "Zadaný adresár neexistuje 12!\n");
            exit(41);
        }
        if (isset($this->find_args_jc)) {
            if ($this->jc_bool) {
                $this->find_args_jc = explode("=", $this->find_args_jc);
                $this->find_args_jc = $this->find_args_jc[1];

                if (!file_exists($this->find_args_jc)) {
                    fwrite(STDERR, "Zadaný adresár neexistuje 13!\n");
                    exit(41);
                }
            }
            if (!file_exists($this->find_args_jc)) {
                fwrite(STDERR, "Zadaný adresár neexistuje 14!\n");
                exit(41);
            }
        } else {
            fwrite(STDERR, "Zadaný adresár neexistuje 15!\n");
            exit(41);
        }
        if ($this->find_args_io && $this->find_args_po) {
            fwrite(STDERR, "Nesprávna kombinácia argumentov 16!\n");
            exit(41);
        }
        if ($this->find_args_io && $this->ps_bool) {
            fwrite(STDERR, "Nesprávna kombinácia argumentov 17!\n");
            exit(41);
        }

        $Regexed_filess = array();
        if ($this->find_args_rec) {
            $Directory = new RecursiveDirectoryIterator($this->find_args_dir);
            $Iterator = new RecursiveIteratorIterator($Directory);
            $Regexed_files = new RegexIterator($Iterator, "/^.+\.src$/i", RecursiveRegexIterator::GET_MATCH);
            foreach ($Regexed_files as $info) {
                array_push($Regexed_filess, $info); #$files[] = $info->getPathname();
            }
        } else {
            $scanner_directoty = array_diff(scandir($this->find_args_dir), array("..", "."));
            $scanner_directoty = array_values($scanner_directoty);
            $arr_len_iter = count($scanner_directoty);
            for ($iter = 0; $iter < $arr_len_iter; $iter++) {
                if (preg_match("/^.+\.src$/", $scanner_directoty[$iter])) {
                   array_push($Regexed_filess, $this->find_args_dir . "/" .$scanner_directoty[$iter]);
                }
            }
        }

        foreach ($Regexed_filess as $test_files) {
            /*
             * Ošetrenie problému kedy pri nerekurzivnom prechadzani direcory prechádza test súbory rozdielne.
             */
            if (($this->find_args_rec && $this->dir_bool) || $this->dir_bool == false) {
                $temp_arr = explode(".src", $test_files[0]);
            } else {
                $string_tmp = $test_files;
                $temp_arr = explode(".src", $string_tmp);
            }

            $test_files = $temp_arr[0];

            if (!file_exists($test_files . ".src")) {
                fwrite(STDERR, "Zle zadana adresa! Pozri sa do napovedy.\n");
                exit(41);
            }

            if (!file_exists($test_files . ".in")) {
                file_put_contents($test_files . ".in", "");
            }
            if (!file_exists($test_files . ".out")) {
                file_put_contents($test_files . ".out", "");
            }
            if (!file_exists($test_files . ".rc")) {
                file_put_contents($test_files . ".rc", "0");
            }

            if ($this->find_args_po == true) {
                exec("php7.4 " . $this->find_args_ps . " < " . $test_files . ".src", $output_po, $parser_rc);
                $file_test_rc = file_get_contents($test_files . ".rc");
                $rec_test = intval($file_test_rc);
                if ($parser_rc == $rec_test) {
                    file_put_contents($test_files . ".tmp", $output_po);
                    $output_po = NULL;
                    $test_out = file_get_contents($test_files . ".out");
                    if (strlen($test_out) == 0) {
                        array_push($this->test_ok_name_pars, $test_files . ".src");
                        $this->test_ok++;
                    } else {
                        exec("java -jar " . $this->find_args_jf . " " . $test_files . ".tmp " . $test_files . ".out " . "/dev/null " . $this->find_args_jc, $output_jexamxml, $jexamxml_rc);
                        if ($jexamxml_rc == 0) {
                            array_push($this->test_ok_name_pars, $test_files . ".src");
                            $this->test_ok++;
                        } else {
                            array_push($this->test_fail_name_pars, $test_files . ".src");
                            $this->test_fail++;
                        }
                    }
                } else {
                    array_push($this->test_fail_name_pars, $test_files . ".src");
                    $this->test_fail++;
                }

                if (file_exists($test_files . ".tmp")) {
                    shell_exec("rm " . $test_files . ".tmp");
                    if (file_exists($test_files . ".tmp.log")) {
                        shell_exec("rm " . $test_files . ".tmp.log");
                    }
                }
            }

            if ($this->find_args_po == false && $this->find_args_io == false) {
                exec("php7.4 " . $this->find_args_ps . " < " . $test_files . ".src" . " > " . $test_files . ".src.tmp" , $output_po, $parser_rc);

                if (file_exists($test_files . ".rc")) {
                    $test_rc = file_get_contents($test_files . ".rc");
                    $test_rec_val = intval($test_rc);
                }
                if ($parser_rc == 0) {
                    exec("python3.8 " . $this->find_args_is . " " . "--input=" . $test_files . ".in" . " < " . $test_files . ".src.tmp" . " > " . $test_files . ".tmp.int",
                        $output_inter, $inter_rc);
                    $file_test_rc = file_get_contents($test_files . ".rc");
                    $rec_test = intval($file_test_rc);
                    if ($inter_rc == 0) {
                        exec("diff " . $test_files . ".tmp.int " . $test_files . ".out", $output_diff, $diff_rc);

                        if ($diff_rc == 0) {
                            $this->test_inter_ok++;
                            array_push($this->test_ok_name_inter, $test_files . ".src");
                        } else {
                            echo "OK\n";
                            $this->test_inter_fail++;
                            array_push($this->test_fail_name_inter, $test_files . ".src");
                        }
                    } else if ($rec_test == $inter_rc) {
                        $this->test_inter_ok++;
                        array_push($this->test_ok_name_inter, $test_files . ".src");
                    } else {
                        echo "OK2\n";
                        $this->test_inter_fail++;
                        array_push($this->test_fail_name_inter, $test_files . ".src");
                    }
                } else if ($test_rec_val == $parser_rc){
                    array_push($this->test_ok_name_pars, $test_files . ".src");
                    $this->test_ok++;
                } else {
                    array_push($this->test_fail_name_pars, $test_files . ".src");
                    $this->test_fail++;
                }

                if (file_exists($test_files . ".src.tmp")) {
                    shell_exec("rm " . $test_files . ".src.tmp");
                }
                if (file_exists($test_files . ".tmp.int")) {
                    shell_exec("rm " . $test_files . ".tmp.int");
                }
            }

            if ($this->find_args_io == true) {
                exec("python3.8 " . $this->find_args_is . " " . "--input=" . $test_files . ".in" . " --source=" . $test_files . ".src > " . $test_files . ".tmp.int" ,
                    $output_inter, $inter_rc);
                $file_test_rc = file_get_contents($test_files . ".rc");
                $rec_test = intval($file_test_rc);
                if ($inter_rc == 0) {
                    if ($rec_test == 0) {
                        exec("diff " . $test_files . ".tmp.int " . $test_files . ".out", $output_diff, $diff_rc);

                        if ($diff_rc == 0) {
                            $this->test_inter_ok++;
                            array_push($this->test_ok_name_inter, $test_files . ".src");
                        } else {
                            echo "OK\n";
                            $this->test_inter_fail++;
                            array_push($this->test_fail_name_inter, $test_files . ".src");
                        }
                    } else {
                        echo "OK1\n";
                        $this->test_inter_fail++;
                        array_push($this->test_fail_name_inter, $test_files . ".src");
                    }
                } else if ($rec_test == $inter_rc) {
                    $this->test_inter_ok++;
                    array_push($this->test_ok_name_inter, $test_files . ".src");
                } else {
                    echo "OK2\n";
                    $this->test_inter_fail++;
                    array_push($this->test_fail_name_inter, $test_files . ".src");
                }

                if (file_exists($test_files . ".tmp")) {
                    shell_exec("rm " . $test_files . ".tmp");
                }
            }
        }

        /*
         * Príprava výsledkov testov pre výsledný html dokument.
         */

        $all_parse_tests = $this->test_ok + $this->test_fail;
        $all_inter_tests = $this->test_inter_ok + $this->test_inter_fail;
        $test_contain = count($this->test_fail_name_pars);
        $test_contain_ok = count($this->test_ok_name_pars);
        $test_inter_contain = count($this->test_fail_name_inter);
        $test_inter_contain_ok = count($this->test_ok_name_inter);
        /*
         * Generovanie vystupneho html súboru na štandardný výstup.
         */
        $html_start =  "<!DOCTYPE html>
        <html>
        <head>
        <title>test.php</title>
        </head>
 
        <body>
        <h1><strong>Testovac&iacute; skript pre parse.php a interpret.py</strong></h1>
        <h2><strong>V&yacute;sledky testov:</strong></h2>";
        $html_OK_parse = "<p><strong>Počet &uacute;spe&scaron;n&yacute;ch testov parse.php : " . "<span style=\"color: #00ff00;\">$this->test_ok</span></strong></p>";
        $html_FAIL_parse = "<p><strong>Počet ne&uacute;spe&scaron;n&yacute;ch testov parse.php : " . "<span style=\"color: #ff0000;\">$this->test_fail</span></strong></p></strong></p>" .
        "<p><strong>Počet vykonan&yacute;ch testov parse.php : $all_parse_tests</strong></p>";
        $html_OK_inter = "<p><strong>Počet &uacute;spe&scaron;n&yacute;ch testov interpret.py : " . "<span style=\"color: #00ff00;\">$this->test_inter_ok</span></strong></p>";
        $html_FAIL_inter = "<p><strong>Počet ne&uacute;spe&scaron;n&yacute;ch testov interpret.py : " . "<span style=\"color: #ff0000;\">$this->test_inter_fail</span></strong></p></strong></p>" .
        "<p><strong>Počet vykonan&yacute;ch testov interpret.py : $all_inter_tests </strong></p>
        <p>&nbsp;</p>
        <p><strong>Zoznam &uacute;spe&scaron;n&yacute;ch testov parse.php:</strong></p>
        </body>";
        $html_end = "</html> ";

        echo $html_start . $html_OK_parse . $html_FAIL_parse. $html_OK_inter . $html_FAIL_inter;
        for ($iter = 0; $iter < $test_contain_ok; $iter++) {
            $temp_string = $this->test_ok_name_pars[$iter];
            echo "<p><strong>$temp_string</strong></p>";
            $temp_string = null;
        }
        echo "<p>&nbsp;</p>
        <p><strong>Zoznam ne&uacute;spe&scaron;n&yacute;ch testov parse.php : </strong></p>";

        for ($iter = 0; $iter < $test_contain; $iter++) {
            $temp_string = $this->test_fail_name_pars[$iter];
            echo "<p><strong>$temp_string</strong></p>";
            $temp_string = null;
        }
        echo "<p>&nbsp;</p>
        <p><strong>Zoznam &uacute;spe&scaron;n&yacute;ch testov interpret.py : </strong></p>";

        for ($iter = 0; $iter < $test_inter_contain; $iter++) {
            $temp_string = $this->test_fail_name_inter[$iter];
            echo "<p><strong>$temp_string</strong></p>";
            $temp_string = null;
        }
        echo "<p>&nbsp;</p>
        <p><strong>Zoznam ne&uacute;spe&scaron;n&yacute;ch testov interpret.py : </strong></p>";

        for ($iter = 0; $iter < $test_inter_contain_ok; $iter++) {
            $temp_string = $this->test_ok_name_inter[$iter];
            echo "<p><strong>$temp_string</strong></p>";
            $temp_string = null;
        }
        echo "$html_end\n";
    }

}

$testPhp = new testPhp();
$testPhp->pars_arg_test($argv);

