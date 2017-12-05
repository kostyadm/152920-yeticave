<tr class="rates__item">
    <td class="rates__info">
        <div class="rates__img">
            <img src="img/rate<?=$pic_number?>.jpg" width="54" height="40" alt="Сноуборд">
        </div>
        <h3 class="rates__title"><a href="lot.php?id=<?=$id?>"><?=$lot_name?></a></h3>
    </td>
    <td class="rates__category">
        <?=$lot_category?>
    </td>
    <td class="rates__timer">
        <div class="timer timer--finishing"><?=$time_remaining?></div>
    </td>
    <td class="rates__price">
        <?=$cost?>
    </td>
    <td class="rates__time">
        <?=time_format($timestamp)?>
    </td>
</tr>