<?php
function rgb_gen($rgb, $percent) {
    $cleaned_percent = preg_replace("/\..*|%/", "", $percent);
    $rgb_increment = 100 - $cleaned_percent;

    $rgb_arr = explode(',', $rgb);
    $rgb_arr[0] + $rgb_increment <= 255 ? $rgb_arr[0]+=$rgb_increment : $rgb_arr[0] = 255;
    $rgb_arr[1] + $rgb_increment <= 255 ? $rgb_arr[1]+=$rgb_increment : $rgb_arr[1] = 255;
    $rgb_arr[2] + $rgb_increment <= 255 ? $rgb_arr[2]+=$rgb_increment : $rgb_arr[2] = 255;

    $new_rgb = implode(',', $rgb_arr);

    return $new_rgb;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cohort Analysis</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <h1>Cohort Analysis - Bootstrap</h1>
            <div class="form-group">
                <form method="GET">
                    <input type="submit" name="go" value="Show Statistic" class="btn btn-default">
                </form>
            </div>
            <?php if (isset($_GET['go'])) { ?>
                <div class="form-group">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#customerchurn">Customer Churn</a></li>
                        <li><a href="#mrrchurn">MRR Churn</a></li>
                        <li><a href="#customeracquisition">Customer acquisition</a></li>
                    </ul>
                </div>
                <?php if (!empty($months_pays)) { ?>
                    <div class="tab-content">
                        <div id="customerchurn" class="tab-pane fade in active">
                            <h1 class="text-center"># of retained customers in month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови потребители</th>
                                        <?php foreach ($only_months as $month) { ?>
                                            <th><?= $month ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $final_sums = array();
                                    $new_cust_sum = array(); //sum of new customers
                                    foreach ($months_pays as $key1 => $month_and_residue) {
                                        $second_col_i = false;
                                        $before_m_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($month_and_residue as $key2 => $month_firms) {
                                                @$final_sums[$key2]+=count($month_firms);
                                                ?>
                                                <?php
                                                foreach ($month_and_residue as $key3 => $month_firms1) {
                                                    if ($key1 == $key3 && $second_col_i == false) {
                                                        $second_col_i = true;
                                                        @$new_cust_sum[$month_i] = count($month_firms1) + $new_cust_sum[$month_i - 1];
                                                        ?>
                                                        <td><?= count($month_firms1) ?></td>
                                                        <?php
                                                    }
                                                }
                                                ?>                
                                                <td>
                                                    <?php
                                                    if ($key1 == $key2 || $before_m_i == true) {
                                                        $before_m_i = true;
                                                        echo count($month_firms);
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr> 
                                        <?php
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        foreach ($final_sums as $sum_of_all) {
                                            ?>
                                            <td><b><?= $sum_of_all ?></b></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="text-center"># of retained customers in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_pays) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $retained_cols_lifet_sum = array(); //sum of every columns
                                    foreach ($months_pays as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= count($month_firms1) ?></td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            $i = 0;
                                            foreach ($months as $key2 => $month) {
                                                @$retained_cols_lifet_sum[$i]+=count($month);
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td><?= count($month) ?></td>
                                                    <?php
                                                    $i++;
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    ?>
                                                    <td><?= count($month) ?></td>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            if ($colspan < count($months_pays) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_pays) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                </table>
                            </div>

                            <h1 class="text-center"># of churned customers in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_pays) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $churn_cols_lifet_sum = array(); //sum of every column
                                    foreach ($months_pays as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= count($month_firms1) ?></td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            $i = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td>0</td>
                                                    <?php
                                                    $churn_cols_lifet_sum[$i] = 0;
                                                    $i++;
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    ?>
                                                    <td><?= $prev > count($month) ? $prev - count($month) : 0 ?> </td>
                                                    <?php
                                                    @$churn_cols_lifet_sum[$i]+=$prev > count($month) ? $prev - count($month) : 0;
                                                    $i++;
                                                }
                                                $prev = count($month);
                                            }
                                            if ($colspan < count($months_pays) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_pays) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                </table>
                            </div>

                            <h1 class="text-center">% of retained customers in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_pays) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $all_per_mon = array();
                                    foreach ($months_pays as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    $all_per_mon[$key] = count($month_firms1);
                                                    ?>
                                                    <td><?= count($month_firms1) ?></td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', '100.00%') ?>);">100.00%</td>
                                                    <?php
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    $percent = @number_format(count($month) / $all_per_mon[$key] * 100, 2) . '%';
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?> </td>
                                                    <?php
                                                }
                                            }
                                            if ($colspan < count($months_pays) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_pays) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        $i = count($new_cust_sum) - 1;
                                        foreach ($retained_cols_lifet_sum as $ret_col) {
                                            $percent = @number_format($ret_col / $new_cust_sum[$i] * 100, 2) . '%';
                                            ?>
                                            <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?></td>
                                            <?php
                                            $i--;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="text-center">% of churned customers in lifetime month (relative to base number)</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_pays) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    foreach ($months_pays as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= count($month_firms1) ?></td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', '0.00%') ?>);">0.00%</td>
                                                    <?php
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    $deliv = $prev - count($month);
                                                    $percent = @number_format($deliv / $all_per_mon[$key] * 100, 2) . '%';
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);">
                                                        <?= $percent ?>
                                                    </td>
                                                    <?php
                                                }
                                                $prev = count($month);
                                            }
                                            if ($colspan < count($months_pays) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_pays) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        $i = count($new_cust_sum) - 1;
                                        foreach ($churn_cols_lifet_sum as $churn_col) {
                                            $percent = @number_format($churn_col / $new_cust_sum[$i] * 100, 2) . '%';
                                            ?>
                                            <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?></td>
                                            <?php
                                            $i--;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="text-center">% of churned customers in lifetime month (relative to previous month)</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_pays) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    foreach ($months_pays as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= count($month_firms1) ?></td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', '0.00%') ?>);">0.00%</td>
                                                    <?php
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    $deliv = $prev - count($month);
                                                    $percent = @number_format($deliv / $prev * 100, 2) . '%';
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);">
                                                        <?= $percent ?>
                                                    </td>
                                                    <?php
                                                }
                                                $prev = count($month);
                                            }
                                            if ($colspan < count($months_pays) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_pays) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        $i = 0;
                                        $j = 0;
                                        foreach ($churn_cols_lifet_sum as $churn_col) {
                                            if ($j == 0) {
                                                $percent = @number_format($churn_col / end($new_cust_sum) * 100, 2) . '%';
                                            } else {
                                                $percent = @number_format($churn_col / $retained_cols_lifet_sum[$i] * 100, 2) . '%';
                                                $i++;
                                            }
                                            ?>
                                            <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?></td>
                                            <?php
                                            $j++;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>
                        </div> <!--end of #customerchurn -->



                        <div id="mrrchurn"  class="tab-pane fade">
                            <h1 class="text-center">Cohort MRR in month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови MRR</th>
                                        <?php foreach ($only_months as $month) { ?>
                                            <th><?= $month ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $final_sums = array();
                                    $sum_of_month_moneys = array(); //sum of new customers
                                    foreach ($months_moneys as $key1 => $month_and_residue) {
                                        $second_col_i = false;
                                        $before_m_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($month_and_residue as $key2 => $month_firms) {
                                                @$final_sums[$key2]+=array_sum($month_firms);
                                                ?>
                                                <?php
                                                foreach ($month_and_residue as $key3 => $month_firms1) {
                                                    if ($key1 == $key3 && $second_col_i == false) {
                                                        $second_col_i = true;
                                                        $sum_of_month_moneys[$month_i] = array_sum($month_firms1) + $sum_of_month_moneys[$month_i - 1];
                                                        ?>
                                                        <td><?= array_sum($month_firms1) ?> лв</td>
                                                        <?php
                                                    }
                                                }
                                                ?>                
                                                <td>
                                                    <?php
                                                    if ($key1 == $key2 || $before_m_i == true) {
                                                        $before_m_i = true;
                                                        echo array_sum($month_firms) . '  лв';
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                            }
                                            ?>
                                        </tr> 
                                        <?php
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        foreach ($final_sums as $sum_of_all) {
                                            ?>
                                            <td><b><?= $sum_of_all ?> лв</b></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="text-center">Retained MRR in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови MRR</th>
                                        <?php for ($i = 0; $i <= count($months_moneys) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $retained_cols_lifet_sum = array(); //sum of every columns
                                    foreach ($months_moneys as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= array_sum($month_firms1) ?> лв</td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            $i = 0;
                                            foreach ($months as $key2 => $month) {
                                                @$retained_cols_lifet_sum[$i]+=array_sum($month);
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td><?= array_sum($month) ?> лв</td>
                                                    <?php
                                                    $i++;
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    ?>
                                                    <td><?= array_sum($month) ?> лв</td>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            if ($colspan < count($months_moneys) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_moneys) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                </table>
                            </div>

                            <h1 class="text-center">MRR churn in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови MRR</th>
                                        <?php for ($i = 0; $i <= count($months_moneys) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $churn_cols_lifet_sum = array(); //sum of every column
                                    foreach ($months_moneys as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= array_sum($month_firms1) ?> лв</td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            $i = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td>0 лв</td>
                                                    <?php
                                                    $churn_cols_lifet_sum[$i] = 0;
                                                    $i++;
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    ?>
                                                    <td><?= $prev - array_sum($month) ?> лв</td>
                                                    <?php
                                                    @$churn_cols_lifet_sum[$i]+=$prev > array_sum($month) ? $prev - array_sum($month) : 0;
                                                    $i++;
                                                }
                                                $prev = array_sum($month);
                                            }
                                            if ($colspan < count($months_moneys) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_moneys) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                </table>
                            </div>

                            <h1 class="text-center">% of retained MRR in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови MRR</th>
                                        <?php for ($i = 0; $i <= count($months_moneys) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $all_per_mon = array();
                                    foreach ($months_moneys as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    $all_per_mon[$key] = array_sum($month_firms1);
                                                    ?>
                                                    <td><?= array_sum($month_firms1) ?> лв</td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', '100.00%') ?>);">100.00%</td>
                                                    <?php
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    $percent = @number_format(array_sum($month) / $all_per_mon[$key] * 100, 2) . '%';
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?> </td>
                                                    <?php
                                                }
                                            }
                                            if ($colspan < count($months_moneys) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_moneys) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        $i = count($sum_of_month_moneys) - 1;
                                        foreach ($retained_cols_lifet_sum as $ret_col) {
                                            $percent = @number_format($ret_col / $sum_of_month_moneys[$i] * 100, 2) . '%';
                                            ?>
                                            <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?></td>
                                            <?php
                                            $i--;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="text-center">% MRR churn in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_moneys) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    foreach ($months_moneys as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= array_sum($month_firms1) ?> лв</td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', '0.00%') ?>);">0.00%</td>
                                                    <?php
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    $deliv = $prev - array_sum($month);
                                                    $percent = @number_format($deliv / $all_per_mon[$key] * 100, 2) . '%';
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);">
                                                        <?= $percent ?>
                                                    </td>
                                                    <?php
                                                }
                                                $prev = array_sum($month);
                                            }
                                            if ($colspan < count($months_moneys) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_moneys) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        $i = count($sum_of_month_moneys) - 1;
                                        foreach ($churn_cols_lifet_sum as $churn_col) {
                                            $percent = @number_format($churn_col / $sum_of_month_moneys[$i] * 100, 2) . '%';
                                            ?>
                                            <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?></td>
                                            <?php
                                            $i--;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="text-center">% MRR churn in lifetime month (relative to previous month)</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови Потребители</th>
                                        <?php for ($i = 0; $i <= count($months_moneys) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    foreach ($months_moneys as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= array_sum($month_firms1) ?> лв</td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            foreach ($months as $key2 => $month) {
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', '0.00%') ?>);">0.00%</td>
                                                    <?php
                                                } elseif ($continue == true) {
                                                    $colspan++;
                                                    $deliv = $prev - array_sum($month);
                                                    if (($prev == 0 && $deliv > 0) || ($deliv == 0 && $prev == 0)) {
                                                        $percent = '0.00%';
                                                    } else {
                                                        $percent = @number_format($deliv / $prev * 100, 2) . '%';
                                                    }
                                                    ?>
                                                    <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);">
                                                        <?= $percent ?>
                                                    </td>
                                                    <?php
                                                }
                                                $prev = array_sum($month);
                                            }
                                            if ($colspan < count($months_moneys) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_moneys) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <?php
                                        $i = 0;
                                        $j = 0;
                                        foreach ($churn_cols_lifet_sum as $churn_col) {
                                            if ($j == 0) {
                                                $percent = @number_format($churn_col / end($sum_of_month_moneys) * 100, 2) . '%';
                                            } else {
                                                $percent = @number_format($churn_col / $retained_cols_lifet_sum[$i] * 100, 2) . '%';
                                                $i++;
                                            }
                                            ?>
                                            <td style="background-color: rgb(<?= rgb_gen('64,128,0', $percent) ?>);"><?= $percent ?></td>
                                            <?php
                                            $j++;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>
                        </div> <!--end of #mrrchurn -->




                        <div id="customeracquisition"  class="tab-pane fade">
                            <h1 class="text-center">Cumulated revenue in lifetime month</h1>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <th width="200px">Месец</th>
                                        <th width="200px">Нови MRR</th>
                                        <?php for ($i = 0; $i <= count($months_moneys) - 1; $i++) { ?>
                                            <th><?= $i ?></th>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $month_i = 0;
                                    $retained_cols_lifet_sum = array(); //sum of every columns
                                    foreach ($months_moneys as $key => $months) {
                                        $second_col_i = false;
                                        ?>
                                        <tr>
                                            <td><?= $only_months[$month_i] ?></td>
                                            <?php
                                            foreach ($months as $key3 => $month_firms1) {
                                                if ($key == $key3 && $second_col_i == false) {
                                                    $second_col_i = true;
                                                    ?>
                                                    <td><?= array_sum($month_firms1) ?> лв</td>
                                                    <?php
                                                }
                                            }
                                            $continue = false;
                                            $colspan = 0;
                                            $i = 0;
                                            foreach ($months as $key2 => $month) {
                                                @$retained_cols_lifet_sum[$i]+=array_sum($month);
                                                if ($key == $key2) {
                                                    $continue = true;
                                                    ?>
                                                    <td><?= array_sum($month) ?> лв</td>
                                                    <?php
                                                    $prev = array_sum($month);
                                                    $i++;
                                                } elseif ($continue == true) {
                                                    $prev = $prev + array_sum($month);
                                                    $colspan++;
                                                    ?>
                                                    <td><?= $prev ?> лв</td>
                                                    <?php
                                                    $i++;
                                                }
                                            }

                                            if ($colspan < count($months_moneys) - 1) {
                                                ?>
                                                <td colspan="<?= count($months_moneys) - 1 - $colspan ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        $month_i++;
                                    }
                                    ?>
                                </table>
                            </div>
                        </div> <!--end of #customeracquisition -->
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger">No Array!</div>
                    <?php
                }
            }
            ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>