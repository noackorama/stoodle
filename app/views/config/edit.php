<?
    $types = array(
        'date'     => _('Datum'),
        'time'     => _('Uhrzeit'),
        'datetime' => _('Datum und Uhrzeit'),
        'text'     => _('Freitext'),
    );
    
    $formatValue = function ($type, $value) {
        if ($type === 'text') {
            return $value;
        }
        
        $templates = array(
            'date'     => '%d.%m.%Y',
            'time'     => '%H:%M',
            'datetime' => '%d.%m.%Y %H:%M',
        );
        
        return $value ? 'value="' . strftime($templates[$type], $value) . '"' : '';
    };
?>

<noscript><?= Messagebox::info(_('Sie haben Javascript deaktiviert. Dadurch ist die Funktionsweise dieser Seite beeintr�chtigt.')) ?></noscript>

<form action="<?= $controller->url_for('config/edit', $id) ?>" method="post">
<table class="default zebra stoodle">
    <colgroup>
        <col width="200">
        <col>
        <col width="200">
    </colgroup>
    <thead>
        <tr>
            <td class="topic" colspan="3">
                <?= $stoodle_id ? _('Umfrage bearbeiten') : _('Neue Umfrage erstellen') ?>
            </td>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th colspan="3"><?= _('Grunddaten') ?></th>
        </tr>
        <tr>
            <td>
                <label for="title"><?= _('Titel') ?></label>
            </td>
            <td colspan="2">
                <input type="text" name="title" id="title"
                       value="<?= htmlReady($title) ?>"
                       style="width:99%">
            </td>
        </tr>
        <tr>
            <td>
                <label for="description"><?= _('Beschreibung') ?></label>
            </td>
            <td colspan="2">
                <textarea class="add_toolbar" name="description" id="description" 
                          style="width:99%"><?= htmlReady($description) ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label for="type"><?= _('Typ') ?></label>
            </td>
            <td colspan="2">
                <select id="type" name="type">
                <? foreach ($types as $t => $n): ?>
                    <option value="<?= $t ?>" <? if ($type == $t) echo 'selected'; ?>>
                        <?= htmlReady($n) ?>
                    </option>
                <? endforeach; ?>
                </select>
            </td>
        </tr>
    </tbody>

    <tbody class="dates">
        <tr>
            <th colspan="3"><?= _('Zeiten') ?></th>
        </tr>
        <tr>
            <td>
                <label for="start_date"><?= _('Start') ?></label>
            </td>
            <td colspan="2">
                <input type="datetime" name="start_date" id="start_date"
                       <?= $formatValue('datetime', $start_date) ?>>
                <label>
                    <input type="checkbox" name="start_date" value="foo"
                           <? if (!$start_date) echo 'checked'; ?>>
                    <?= _('Offen') ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label for="end_date"><?= _('Ende') ?></label>
            </td>
            <td colspan="2">
                <input type="datetime" name="end_date" id="end_date"
                       <?= $formatValue('datetime', $end_date) ?>>
                <label>
                    <input type="checkbox" name="end_date" value=""
                           <? if (!$end_date) echo 'checked'; ?>>
                    <?= _('Offen') ?>
                </label>
            </td>
        </tr>
    </tbody>

    <tbody>
        <tr>
            <th colspan="3"><?= _('Optionen') ?></th>
        </tr>
        <tr>
            <td>
                <label for="allow_comments"><?= _('Kommentare erlauben') ?></label>
            </td>
            <td colspan="2">
                <input type="hidden" name="allow_comments" value="0">
                <input type="checkbox" name="allow_comments" id="allow_comments" value="1"
                       <? if ($allow_comments) echo 'checked'; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <label for="is_public"><?= _('F�r alle einsehbar') ?></label>
                <?= tooltipicon(_('Die gegebenen Antworten der Teilnehmer sind f�r andere Teilnehmer nicht sichtbar.')) ?>
            </td>
            <td colspan="2">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" id="is_public" value="1"
                       <? if ($is_public) echo 'checked'; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <label for="is_anonymous"><?= _('Anonyme Teilnahme') ?></label>
                <?= tooltipicon(_('Die Namen der Teilnehmer sind f�r andere Teilnehmer nicht sichtbar.')) ?>
            </td>
            <td colspan="2">
                <input type="hidden" name="is_anonymous" value="0">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                       <? if ($is_anonymous) echo 'checked'; ?>>
            </td>
        </tr>
        <tr>
            <td>
                <label for="allow_maybe"><?= _('"Vielleicht"') ?></label>
                <?= tooltipicon(_('Teilnehmer k�nnen auch "Vielleicht" als Antwort geben.')) ?>
            </td>
            <td colspan="2">
                <input type="hidden" name="allow_maybe" value="0">
                <input type="checkbox" name="allow_maybe" id="allow_maybe" value="1"
                       <? if ($allow_maybe) echo 'checked'; ?>>
            </td>
        </tr>
    </tbody>

    <tbody class="options">
        <tr>
            <th colspan="3"><?= _('Antwortm�glichkeiten') ?></th>
        </tr>
    <? $index = 0; foreach ($options as $id => $value): ?>
        <tr>
            <td>#<?= $index + 1 ?></td>
            <td>
                <input type="<?= $type ?>" name="options[<?= $id ?>]"
                    <?= $formatValue($type, $value) ?>
                    <? if (isset($focussed) && $focussed == $index) echo 'autofocus'; ?>>
            </td>
            <td style="text-align: right;" class="actions">
            <? if ($index > 0): ?>
                <button name="move[up]" value="<?= $index ?>" title="<?= _('Antwort nach oben verschieben') ?>">
                    <?= Assets::img('icons/16/yellow/arr_2up', array('alt' => _('Antwort nach oben verschieben'))) ?>
                </button>
            <? else: ?>
                <button disabled>
                    <?= Assets::img('icons/16/grey/arr_2up') ?>
                </button>
            <? endif; ?>
            <? if ($index < count($options) - 1): ?>
                <button name="move[down]" value="<?= $index ?>" title="<?= _('Antwort nach unten verschieben') ?>">
                    <?= Assets::img('icons/16/yellow/arr_2down', array('alt' => _('Antwort nach unten verschieben'))) ?>
                </button>
            <? else: ?>
                <button disabled>
                    <?= Assets::img('icons/16/grey/arr_2down') ?>
                </button>
            <? endif; ?>
                <button name="remove" value="<?= $index ?>" title="<?= _('Antwort l�schen') ?>">
                    <?= Assets::img('icons/16/blue/trash', array('alt' => _('Antwort l�schen'))) ?>
                </button>
            </td>
        </tr>
    <? $index += 1; endforeach; ?>
        <tr class="steelkante">
            <td style="text-align: right" colspan="3">
                <?= Studip\Button::create(_('Weitere Antwortm�glichkeit hinzuf�gen'), 'add') ?>
            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr class="steel">
            <td colspan="3" style="text-align: center;">
                <div class="button-group">
                    <?= Studip\Button::createAccept(_('Speichern'), 'store') ?>
                    <?= Studip\LinkButton::createCancel(_('Abbrechen'), $controller->url_for('config')) ?>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
</form>