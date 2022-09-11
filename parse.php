<?php
# Jozef Makiš

ini_set('display_errors', 'stderr');

$ins_arg_1 = 1;
$ins_arg_2 = 2;
$ins_arg_3 = 3;
$ins_arg_4 = 4;
$empty_count = 0;
$match_count_line = 0;
$end_arg_check = 0;
$comm_start = "/^#.*/";

/*
 * Funkcií je predávané pole argumentov. V prípade chybných argumentov vráti chybovú hlášku.
 */
function pars_arg ($argv) {
    if (count($argv) == 2) {
        if ($argv[1] == "--help") {
            echo "Použitie: php7.4 parse.php parametry\n";
            echo "Základne parametry: --help pre vypis nápovedy.\n";
            echo "Parametry rozšírenia:\n
            --stats=file pre zadanie zdrojovového súboru pre statistiky za --stats,\n
            --loc počet riadkov s inštrukciami,\n
            --comments počet riadkov s komentarom,\n
            --labels počet návestí,\n
            --jumps počet všetkých inštrukcií návratov z volania a inštrukcii skokov,\n
            --fwjumps počet skokov vpred,\n
            --backjumps spätné skoky,\n
            --badjumps počet skokov neexistujucích návestí.\n";
            exit(0);
        }
    } else if (count($argv) == 1) {
        return;
    } else {
        echo "Chýbajú parametre! Pre pomoc skús parameter --help.\n";
        exit(10);
    }
}

/*
 * Funkcií je predaný počet argumentov inštrukcie, jej správny počet argumentov a pole argumentov.
 * Funkcia kontroluje správnosť a počet argumentov.
 */
function inst_arg_check($count, $count_needed, $raw_inst) {
    $comm_start_inst = "/^#.*/";
    $empty_count = 0;
    $end_arg_check_inst = 0;

    if ($count != $count_needed) {
        if ($count == 1) {
            for ($iter = 1; $iter < $count_needed; $iter++) {
                $match_res = preg_match($comm_start_inst, $raw_inst[$iter]);

                if ($match_res > 0) {
                    $end_arg_check_inst++;
                    $match_count_line_inst = $iter;
                    if ($match_count_line_inst - 1 == $empty_count) {
                        break;
                    } else {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                } else if (empty($raw_inst[$iter])) {
                    $empty_count++;
                } else if ($iter == $count_needed - 1) {
                    if ($end_arg_check_inst == 0) {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                }
            }
        } else if ($count == 2) {
            for ($iter = 2; $iter < $count_needed; $iter++) {
                $match_res = preg_match($comm_start_inst, $raw_inst[$iter]);
                if ($match_res > 0) {
                    $end_arg_check_inst++;
                    $match_count_line = $iter;
                    if ($match_count_line - 2 == $empty_count) {
                        break;
                    } else {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                } else if (empty($raw_inst[$iter])) {
                    $empty_count++;
                } else if ($iter == $count_needed - 1) {
                    if ($end_arg_check_inst == 0) {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                }
            }
        } else if ($count == 3) {
            for ($iter = 3; $iter < $count_needed; $iter++) {
                $match_res = preg_match($comm_start_inst, $raw_inst[$iter]);

                if ($match_res > 0) {
                    $end_arg_check_inst++;
                    $match_count_line = $iter;
                    if ($match_count_line - 3 == $empty_count) {
                        break;
                    } else {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                } else if (empty($raw_inst[$iter])) {
                    $empty_count++;
                } else if ($iter == $count_needed - 1) {
                    if ($end_arg_check_inst == 0) {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                }
            }
        } else if ($count == 4) {
            for ($iter = 4; $iter < $count_needed; $iter++) {
                $match_res = preg_match($comm_start_inst, $raw_inst[$iter]);

                if ($match_res > 0) {
                    $end_arg_check_inst++;
                    $match_count_line = $iter;
                    if ($match_count_line - 4 == $empty_count) {
                        break;
                    } else {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                } else if (empty($raw_inst[$iter])) {
                    $empty_count++;
                } else if ($iter == $count_needed - 1) {
                    if ($end_arg_check_inst == 0) {
                        fwrite(STDERR, "Nesprávny počet argumentov inštrukcie!\n");
                        exit(23);
                    }
                }
            }
        }
    }
}

/*
 * Funkcií je predaný typ inštrukcie.
 * Funkcia kontroluje typ inštrukcie.
 */
function type_check ($type) {
    $type_match = "/^(string)|(int)|(bool)$/";

    if (preg_match($type_match, $type) == 0 || false) {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Kontrola typu zlyhala.\n");
        exit(23);
    }
}

/*
 * Funkcií je predané návestie inštrukcie.
 * Funkcia kontroluje návestie inštrukcie.
 */
function lab_check ($lab) {
    $lab_match = "/^[a-zA-Z_\-$&%*!?][a-zA-Z0-9_\-$&%*!?]*$/";

    if (preg_match($lab_match, $lab) == 0 || false) {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Kontrola návestia zlyhala.\n");
        exit(23);
    }

}

/*
 * Funkcií je predaná premenná inštrukcie.
 * Funkcia premennú inštrukcie.
 */
function var_check ($var) {
    $var_match = "/^(LF|GF|TF)@[a-zA-Z\-$&%*!?_][a-zA-Z0-9\-$&%*!?_]*$/";

    if (preg_match($var_match, $var) == 0 || false) {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Kontrola var zlyhala.\n");
        exit(23);
    }
}

/*
 * Funkcií je predaná konštanta, alebo premenná inštrukcie.
 * Funkcia kontroluje konštantu, alebo premennú inštrukcie.
 */
function symb_check ($symb) {
    $symb_match = "/(^int@[+-]?[0-9]+$)|(^nil@nil$)|(^bool@(true$)|(false$)|^string@.*$)/";
    $var_match = "/^(LF|GF|TF)@[a-zA-Z\-$&%*!?_][a-zA-Z0-9\-$&%*!?_]*$/";
    $string_sec = "/^string@.*$/";

    if (((preg_match($symb_match, $symb)) == 0 || false) && (preg_match($var_match, $symb) == 0 || false)) {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Kontrola symbolu zlyhala.\n");
        exit(23);
    }

    if (preg_match($string_sec, $symb)) {
        $c_string = substr($symb, 7);
        $esc_check = "/\\\\/";
        if(preg_match_all($esc_check, $c_string)) {
            $test_eq_slash = preg_match_all($esc_check, $c_string);
            $esc_final = "/\\\\[0-9]{3}/";
            $test_eq = preg_match_all($esc_final, $c_string);

            if ($test_eq == 0 || $test_eq == false) {
                fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Kontrola reťazca zlyhala.\n");
                exit(23);
            } else if ($test_eq_slash != $test_eq) {
                fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Kontrola escape sekvencii.\n");
                exit(23);
            }
        }

    }
}

/*
 * Funkcií je predaný neskontrolovany typ argumentu.
 * Funkcia kontroluje typ argumentu.
 */
function type_read ($raw_type) {
    $type_read = "/(^int$)|(^string$)|(^bool$)/";

    if (preg_match($type_read, $raw_type)) {
        $type_int = "/^int$/";
        $type_string = "/^string$/";
        $type_bool = "/^bool$/";

        if (preg_match($type_int, $raw_type)) {
            return "int";
        } else if (preg_match($type_bool, $raw_type)) {
            return "bool";
        } else if (preg_match($type_string, $raw_type)) {
            return "string";
        }
    } else {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Typ: $raw_type\n");
        exit(23);
    }
}

/*
 * Funkcií je predaný typ konštanty, alebo premennej inštrukcie.
 * Funkcia upravuje typ konštanty, alebo premennú pre zápis do xml.
 */
function symb_type_dec ($raw_type) {
    $type_val = "/(^int@)|(^string@)|(^bool@)|(^nil@)/";
    $var_match = "/^(LF|GF|TF)@[a-zA-Z\-$&%*!?_][a-zA-Z0-9\-$&%*!?_]*$/";

    if (preg_match($type_val, $raw_type) || preg_match($var_match, $raw_type)) {
        $type_int = "/^int@/";
        $type_string = "/^string@/";
        $type_bool = "/^bool@/";
        $type_nil = "/^nil@/";
        $type_var_LF = "/^LF@/";
        $type_var_GF = "/^GF@/";
        $type_var_TF = "/^TF@/";

        if (preg_match($type_int, $raw_type)) {
            return "int";
        } else if (preg_match($type_string, $raw_type)) {
            return "string";
        } else if (preg_match($type_bool, $raw_type)) {
            return "bool";
        } else if (preg_match($type_var_LF, $raw_type) || preg_match($type_var_GF, $raw_type) ||
            preg_match($type_var_TF, $raw_type)) {
            return "var";
        } else if (preg_match($type_nil, $raw_type)) {
            return "nil";
        }
    } else {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Typ symbolu: $raw_type\n");
        exit(23);
    }
}

/*
 * Funkcií je predaná hodnota konštanty, alebo premennej inštrukcie.
 * Funkcia upravuje hodnotu konštanty, alebo premennej pre zápis do xml.
 */
function symb_val_dec ($raw_val) {
    $type_val = "/(^int@)|(^string@)|(^bool@)|(^nil@)/";
    $var_match = "/^(LF|GF|TF)@/";

    if (preg_match($type_val, $raw_val) || preg_match($var_match, $raw_val)) {
        $type_int = "/^int@/";
        $type_string = "/^string@/";
        $type_bool = "/^bool@/";
        $type_nil = "/^nil@/";
        $type_var_LF = "/^LF@/";
        $type_var_GF = "/^GF@/";
        $type_var_TF = "/^TF@/";

        if (preg_match($type_int, $raw_val)) {
            return substr($raw_val, 4);
        } else if (preg_match($type_string, $raw_val)) {
            return substr($raw_val, 7);
        } else if (preg_match($type_bool, $raw_val)) {
            return substr($raw_val, 5);
        } else if (preg_match($type_var_LF, $raw_val) || preg_match($type_var_GF, $raw_val) ||
            preg_match($type_var_TF, $raw_val)) {
            return $raw_val;
        } else if (preg_match($type_nil, $raw_val)) {
            return "nil";
        }
    } else {
        fwrite(STDERR, "Vyskytla sa lexikálna, alebo syntaktická chyba. Hodnota symbolu: $raw_val\n");
        exit(23);
    }
}

/*
 * Funkcií je predaný obash pamäte xml, poradové číslo inštrukcie, jej operačný kód, počet argumentov, následne
 * volitelné parametry ako je typ a hodnota inštrukcie.
 * Funkcia vytvára výsledny format xml výstupu.
 */
function inst_gen ($xw, $order, $opcode, $arg_c, $arg1, $arg1_t, $arg2, $arg2_t, $arg3, $arg3_t) {
    xmlwriter_start_element($xw,"instruction");
    xmlwriter_write_attribute($xw, "order", $order);
    xmlwriter_write_attribute($xw, "opcode", $opcode);

    if ($arg_c == 1) {
        xmlwriter_start_element($xw,"arg1");
        xmlwriter_write_attribute($xw, "type", $arg1_t);
        xmlwriter_text($xw, $arg1);
        xmlwriter_end_element($xw);
    } else if ($arg_c == 2) {
        xmlwriter_start_element($xw,"arg1");
        xmlwriter_write_attribute($xw, "type", $arg1_t);
        xmlwriter_text($xw, $arg1);
        xmlwriter_end_element($xw);

        xmlwriter_start_element($xw,"arg2");
        xmlwriter_write_attribute($xw, "type", $arg2_t);
        xmlwriter_text($xw, $arg2);
        xmlwriter_end_element($xw);
    } else if ($arg_c == 3) {
        xmlwriter_start_element($xw,"arg1");
        xmlwriter_write_attribute($xw, "type", $arg1_t);
        xmlwriter_text($xw, $arg1);
        xmlwriter_end_element($xw);

        xmlwriter_start_element($xw,"arg2");
        xmlwriter_write_attribute($xw, "type", $arg2_t);
        xmlwriter_text($xw, $arg2);
        xmlwriter_end_element($xw);

        xmlwriter_start_element($xw,"arg3");
        xmlwriter_write_attribute($xw, "type", $arg3_t);
        xmlwriter_text($xw, $arg3);
        xmlwriter_end_element($xw);
    }

    xmlwriter_end_element($xw);
}

/*
 * Funkcia odstraňuje prebytočné prázdne miesta zo vstupu.
 */
function space_remover($inst_line_arr) {
    $arr_len = count($inst_line_arr);

    for ($iter = 0; $iter < $arr_len; $iter++) {
        if (empty($inst_line_arr[$iter])) {
            unset($inst_line_arr[$iter]);
        }
    }
    $inst_line_arr = array_values($inst_line_arr);
    return $inst_line_arr;
}

/*
 * Funkcia oddeluje komentáre od inštrukcií.
 */
function commet_spliter($inst_line) {
    $arr_len = count($inst_line);
    $symb_match = "/(^int@[+-]?[0-9]+#.*)|(^nil@nil#.*)|(^bool@(true#.*)|(false#.*)|^string@.*#.*)/";
    $var_match = "/^(LF|GF|TF)@[a-zA-Z\-$&%*!?_][a-zA-Z0-9\-$&%*!?_]*#.*/";
    $comm_start = "/#.*/";
    $removing_comm = false;

    for ($iter = 0; $iter < $arr_len; $iter++) {
        $result_symb = preg_match($symb_match , $inst_line[$iter]);
        $result_var = preg_match($var_match, $inst_line[$iter]);

        if ($result_symb) {
            $inst_line[$iter] = preg_replace($comm_start, "", $inst_line[$iter]);
            $removing_comm = true;
        } else if ($result_var) {
            $inst_line[$iter] = preg_replace($comm_start, "", $inst_line[$iter]);
            $removing_comm = true;
        } else if ($removing_comm) {
            unset($inst_line[$iter]);
        }
    }
    $inst_line = array_values($inst_line);
    return $inst_line;
}

pars_arg($argv);

$header_checker = false;
$raw_inst = [];
$instr_count = 0;
$non_use_arg = NULL;

while ($line_string = fgets(STDIN)) {

    $raw_inst = trim($line_string, "\n"); // oddeluje konce riadkov z poľa
    $raw_inst = explode(" ", $raw_inst); // oddeluje inštrukcie prazdnym miestom
    $raw_inst = space_remover($raw_inst); // odstranuje prazdne argumenty
    $raw_inst = commet_spliter($raw_inst); // oddeluje komenty od inštrukcii

    $arr_len = count($raw_inst);

    if (!isset($raw_inst[0])) {
        continue;
    }

    if (preg_match($comm_start, $raw_inst[0])) {
        continue;
    }

    if(empty($raw_inst[0])){
        continue;
    }

    if ($header_checker == false) {
        if ((strcmp($raw_inst[0], ".IPPcode21") == 0 && $instr_count == 0) || preg_match("/^.IPPcode21#.+$/", $raw_inst[0])) {
            if ($arr_len != 1) {
                // kontrola toho co sa nachadza za hlavickou
                for ($iter = 1; $iter < $arr_len; $iter++) {
                    $match_res = preg_match($comm_start, $raw_inst[$iter]);

                    if ($match_res > 0) {
                        $end_arg_check++;
                        $match_count_line = $iter;
                        if ($match_count_line - 1 == $empty_count) {
                            break;
                        } else {
                            fwrite(STDERR, "Chybná hlavička súboru !\n");
                            exit(21);
                        }
                    } else if (empty($raw_inst[$iter])) {
                        $empty_count++;
                    } else if ($iter == $arr_len - 1) {
                        if ($end_arg_check == 0) {
                            fwrite(STDERR, "Chybná hlavička súboru !\n");
                            exit(21);
                        }
                    }
                }
            }

            $xw = xmlwriter_open_memory();
            xmlwriter_set_indent($xw, 1);
            xmlwriter_start_document($xw, '1.0', 'UTF-8');
            xmlwriter_start_element($xw, 'program');
            xmlwriter_write_attribute($xw, 'language', "IPPcode21");
            $header_checker = true;
            continue;
        } else {
            fwrite(STDERR, "Chybná hlavička súboru !\n");
            exit(21);
        }
    }

    switch (strtoupper($raw_inst[0])) {
        case "MOVE":
            inst_arg_check(3, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            inst_gen($xw, $instr_count, "MOVE", 2,  $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]), $non_use_arg, $non_use_arg);
            break;
        case "CREATEFRAME":
            inst_arg_check(1, $arr_len, $raw_inst);
            $instr_count++;
            inst_gen($xw, $instr_count, "CREATEFRAME", 0,  $non_use_arg, $non_use_arg,
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "PUSHFRAME":
            inst_arg_check(1, $arr_len, $raw_inst);
            $instr_count++;
            inst_gen($xw, $instr_count, "PUSHFRAME", 0,  $non_use_arg, $non_use_arg,
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "POPFRAME":
            inst_arg_check(1, $arr_len, $raw_inst);
            $instr_count++;
            inst_gen($xw, $instr_count, "POPFRAME", 0,  $non_use_arg, $non_use_arg,
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "DEFVAR":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "DEFVAR", 1,  $raw_inst[1], "var",
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "CALL":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            lab_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "CALL", 1,  $raw_inst[1], "label",
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "RETURN":
            inst_arg_check(1, $arr_len, $raw_inst);
            $instr_count++;
            inst_gen($xw, $instr_count, "RETURN", 0,  $non_use_arg, $non_use_arg,
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "PUSHS":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            symb_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "PUSHS", 1,  symb_val_dec($raw_inst[1]), symb_type_dec($raw_inst[1]),
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "POPS":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "POPS", 1,  $raw_inst[1], "var",
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "ADD":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "ADD", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "SUB":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "SUB", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "MUL":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "MUL", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "IDIV":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "IDIV", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "LT":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "LT", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "GT":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "GT", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "EQ":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "EQ", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "AND":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "AND", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "OR":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "OR", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "NOT":
            inst_arg_check(3, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            inst_gen($xw, $instr_count, "NOT", 2, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                $non_use_arg, $non_use_arg);
            break;
        case "INT2CHAR":
            inst_arg_check(3, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            inst_gen($xw, $instr_count, "INT2CHAR", 2, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                $non_use_arg, $non_use_arg);
            break;
        case "STRI2INT":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "STRI2INT", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "READ":
            inst_arg_check(3, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            type_check($raw_inst[2]);
            inst_gen($xw, $instr_count, "READ", 2, $raw_inst[1], "var",
                type_read($raw_inst[2]), "type",
                $non_use_arg, $non_use_arg);
            break;
        case "WRITE":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            symb_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "WRITE", 1,  symb_val_dec($raw_inst[1]), symb_type_dec($raw_inst[1]),
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "CONCAT":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "CONCAT", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "STRLEN":
            inst_arg_check(3, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            inst_gen($xw, $instr_count, "STRLEN", 2, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                $non_use_arg, $non_use_arg);
            break;
        case "GETCHAR":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "GETCHAR", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "SETCHAR":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "SETCHAR", 3, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "TYPE":
            inst_arg_check(3, $arr_len, $raw_inst);
            $instr_count++;
            var_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            inst_gen($xw, $instr_count, "TYPE", 2, $raw_inst[1], "var",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                $non_use_arg, $non_use_arg);
            break;
        case "LABEL":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            lab_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "LABEL", 1, $raw_inst[1], "label",
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "JUMP":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            lab_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "JUMP", 1, $raw_inst[1], "label",
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "JUMPIFEQ":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            lab_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "JUMPIFEQ", 3, $raw_inst[1], "label",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "JUMPIFNEQ":
            inst_arg_check(4, $arr_len, $raw_inst);
            $instr_count++;
            lab_check($raw_inst[1]);
            symb_check($raw_inst[2]);
            symb_check($raw_inst[3]);
            inst_gen($xw, $instr_count, "JUMPIFNEQ", 3, $raw_inst[1], "label",
                symb_val_dec($raw_inst[2]), symb_type_dec($raw_inst[2]),
                symb_val_dec($raw_inst[3]), symb_type_dec($raw_inst[3]));
            break;
        case "EXIT":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            symb_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "EXIT", 1,  symb_val_dec($raw_inst[1]), symb_type_dec($raw_inst[1]),
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "DPRINT":
            inst_arg_check(2, $arr_len, $raw_inst);
            $instr_count++;
            symb_check($raw_inst[1]);
            inst_gen($xw, $instr_count, "DPRINT", 1,  symb_val_dec($raw_inst[1]), symb_type_dec($raw_inst[1]),
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        case "BREAK":
            inst_arg_check(1, $arr_len, $raw_inst);
            $instr_count++;
            inst_gen($xw, $instr_count, "BREAK", 0,  $non_use_arg, $non_use_arg,
                $non_use_arg, $non_use_arg, $non_use_arg, $non_use_arg);
            break;
        default:
            fwrite(STDERR, "Chybná inštrukcia !\n");
            exit(22);
    }
}

xmlwriter_end_element($xw);
xmlwriter_end_document($xw);
echo xmlwriter_output_memory($xw);
?>
