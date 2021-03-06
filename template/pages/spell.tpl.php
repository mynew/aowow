<?php $this->brick('header'); ?>

    <div class="main" id="main">
        <div class="main-precontents" id="main-precontents"></div>
        <div class="main-contents" id="main-contents">

<?php
    $this->brick('announcement');

    $this->brick('pageTemplate');

    $this->brick('infobox');
?>

            <div class="text">

<?php $this->brick('redButtons'); ?>

                <h1 class="h1-icon"><?php echo $this->name; ?></h1>

<?php
$this->brick('tooltip');

if ($this->reagents[1]):
    if ($this->tools):
        echo "                <div style=\"float: left; margin-right: 75px\">\n";
    endif;

    $this->brick('reagentList', ['reagents' => $this->reagents[1], 'enhanced' => $this->reagents[0]]);

    if ($this->tools):
        echo "                </div>\n";

        if ($this->reagents[0]):
            echo "                <div style=\"float: left\">\n";
        endif;
?>
                <h3><?php echo Lang::spell('tools'); ?></h3>
                <table class="iconlist">
<?php
        foreach ($this->tools as $i => $t):
            echo '                    <tr><th align="right" id="iconlist-icon'.($i + 1).'"></th><td><span class="q1"><a href="'.$t['url'].'">'.$t['name']."</a></span></td></tr>\n";
        endforeach;
?>
                </table>
                <script type="text/javascript">
<?php
        foreach ($this->tools as $i => $t):
            if (isset($t['itemId'])):
                echo "                    \$WH.ge('iconlist-icon.".($i + 1)."').appendChild(g_items.createIcon(".$t['itemId'].", 0, 1));\n";
            endif;
        endforeach;
?>
                </script>
<?php
        if ($this->reagents[0]):
            echo "                </div>\n";
        endif;
    endif;
endif;
?>
                <div class="clear"></div>

<?php $this->brick('article'); ?>

<?php
if (!empty($this->transfer)):
    echo "    <div class=\"pad\"></div>\n    ".$this->transfer."\n";
endif;
?>

                <h3><?php echo Lang::spell('_spellDetails'); ?></h3>

                <table class="grid" id="spelldetails">
                    <colgroup>
                        <col width="8%" />
                        <col width="42%" />
                        <col width="50%" />
                    </colgroup>
                    <tr>
                        <td colspan="2" style="padding: 0; border: 0; height: 1px"></td>
                        <td rowspan="6" style="padding: 0; border-left: 3px solid #404040">
                            <table class="grid" style="border: 0">
                            <tr>
                                <td style="height: 0; padding: 0; border: 0" colspan="2"></td>
                            </tr>
                            <tr>
                                <th style="border-left: 0; border-top: 0"><?php echo Lang::game('duration'); ?></th>
                                <td width="100%" style="border-top: 0"><?php echo !empty($this->duration) ? $this->duration : '<span class="q0">'.Lang::main('n_a').'</span>'; ?></td>
                            </tr>
                            <tr>
                                <th style="border-left: 0"><?php echo Lang::game('school'); ?></th>
                                <td width="100%" style="border-top: 0"><?php echo !empty($this->school[1]) ? (User::isInGroup(U_GROUP_STAFF) ? sprintf(Util::$dfnString, $this->school[0], $this->school[1]) : $this->school[1]) : '<span class="q0">'.Lang::main('n_a').'</span>'; ?></td>
                            </tr>
                            <tr>
                                <th style="border-left: 0"><?php echo Lang::game('mechanic'); ?></th>
                                <td width="100%" style="border-top: 0"><?php echo !empty($this->mechanic) ? $this->mechanic : '<span class="q0">'.Lang::main('n_a').'</span>'; ?></td>
                            </tr>
                            <tr>
                                <th style="border-left: 0"><?php echo Lang::game('dispelType'); ?></th>
                                <td width="100%" style="border-top: 0"><?php echo !empty($this->dispel) ? $this->dispel : '<span class="q0">'.Lang::main('n_a').'</span>'; ?></td>
                            </tr>
                            <tr>
                                <th style="border-bottom: 0; border-left: 0"><?php echo Lang::spell('_gcdCategory'); ?></th>
                                <td style="border-bottom: 0"><?php echo !empty($this->gcdCat) ? $this->gcdCat : '<span class="q0">'.Lang::main('n_a').'</span>'; ?></td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th style="border-top: 0"><?php echo Lang::spell('_cost'); ?></th>
                        <td style="border-top: 0"><?php echo !empty($this->powerCost) ? $this->powerCost : Lang::spell('_none'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo Lang::spell('_range'); ?></th>
                        <td><?php echo $this->range.' '.Lang::spell('_distUnit').' <small>('.$this->rangeName; ?>)</small></td>
                    </tr>
                    <tr>
                        <th><?php echo Lang::spell('_castTime'); ?></th>
                        <td><?php echo $this->castTime; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo Lang::spell('_cooldown'); ?></th>
                        <td><?php echo !empty($this->cooldown) ? $this->cooldown : '<span class="q0">'.Lang::main('n_a').'</span>'; ?></td>
                    </tr>
                    <tr>
                        <th><dfn title="<?php echo Lang::spell('_globCD').'">'.Lang::spell('_gcd'); ?></dfn></th>
                        <td><?php echo $this->gcd; ?></td>
                    </tr>
<?php
// not default values
if (!in_array(array_values($this->scaling), [[-1, -1, 0, 0], [0, 0, 0, 0]])):
?>
                    <tr>
                        <th><?php echo Lang::spell('_scaling'); ?></th>
                        <td colspan="3">

<?php
    foreach ($this->scaling as $k => $s):
        if ($s > 0):
            echo '                            '.sprintf(Lang::spell('scaling', $k), $s * 100)."<br>\n";
        endif;
    endforeach;
?>
                        </td>
                    </tr>
<?php
endif;

if (!empty($this->stances)):
?>
                    <tr>
                        <th><?php echo Lang::spell('_forms'); ?></th>
                        <td colspan="3"><?php echo $this->stances; ?></td>
                    </tr>
<?php
endif;

if (!empty($this->items)):
?>
                    <tr>
                        <th><?php echo Lang::game('requires2'); ?></th>
                        <td colspan="3"><?php echo User::isInGroup(U_GROUP_STAFF) ? sprintf(Util::$dfnString, implode(' | ', $this->items[0]), $this->items[1]) : $this->items[1]; ?></td>
                    </tr>
<?php
endif;

foreach ($this->effects as $i => $e):
?>
                    <tr>
                        <th><?php echo Lang::spell('_effect').' #'.($i + 1); ?></th>
                        <td colspan="3" style="line-height: 17px">
<?php
    echo '                            '.$e['name'].'<small>' .
        (isset($e['value'])    ? '<br>'.Lang::spell('_value')   .Lang::main('colon').$e['value']    : null) .
        (isset($e['radius'])   ? '<br>'.Lang::spell('_radius')  .Lang::main('colon').$e['radius'].' '.Lang::spell('_distUnit') : null) .
        (isset($e['interval']) ? '<br>'.Lang::spell('_interval').Lang::main('colon').$e['interval'] : null) .
        (isset($e['mechanic']) ? '<br>'.Lang::game('mechanic')  .Lang::main('colon').$e['mechanic'] : null);

    if (isset($e['procData'])):
        echo '<br>';

        if ($e['procData'][0] < 0):
            echo sprintf(Lang::spell('ppm'), -$e['procData'][0]);
        elseif ($e['procData'][0] < 100.0):
            echo Lang::spell('procChance').Lang::main('colon').$e['procData'][0].'%';
        endif;

        if ($e['procData'][1]):
            if ($e['procData'][0] < 100.0):
                echo '<br>';
            endif;
            echo sprintf(Lang::game('cooldown'), $e['procData'][1]);
        endif;
    endif;

    echo "</small>\n";

    if (isset($e['icon'])):
?>
                            <table class="icontab">
                                <tr>
                                    <th id="icontab-icon<?php echo $i; ?>"></th>
<?php
        if (isset($e['icon']['quality'])):
            echo '                                    <td><span class="q'.$e['icon']['quality'].'"><a href="?item='.$e['icon']['id'].'">'.$e['icon']['name']."</a></span></td>\n";
        else:
            echo '                                    <td>'.(strpos($e['icon']['name'], '#') ? $e['icon']['name'] : sprintf('<a href="?spell=%d">%s</a>', $e['icon']['id'], $e['icon']['name']))."</td>\n";
        endif;
?>
                                    <th></th><td></td>
                                </tr>
                            </table>
                            <script type="text/javascript">
                                <?php echo '$WH.ge(\'icontab-icon'.$i.'\').appendChild('.(isset($e['icon']['quality']) ? 'g_items' : 'g_spells').'.createIcon('.$e['icon']['id'].', 1, '.$e['icon']['count']."));\n"; ?>
                            </script>
<?php
endif;
?>
                        </td>
                    </tr>
<?php
endforeach;
?>
                </table>

                <h2 class="clear"><?php echo Lang::main('related'); ?></h2>
            </div>

<?php
$this->brick('lvTabs', ['relTabs' => true]);

$this->brick('contribute');
?>
            <div class="clear"></div>
        </div><!-- main-contents -->
    </div><!-- main -->

<?php $this->brick('footer'); ?>
