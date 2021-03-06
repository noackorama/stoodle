<? $limit = $comments ? count($stoodle->comments) : 5; ?>

<div id="comments">
    <h3>
    <? if (empty($stoodle->comments)): ?>
        <?= _('Kommentare') ?>
    <? elseif (count($stoodle->comments) > 1): ?>
        <?= sprintf(_('%u Kommentare'), count($stoodle->comments)) ?>
    <? else: ?>
        <?= _('1 Kommentar') ?>
    <? endif; ?>
    </h3>
<? if (!$stoodle->end_date || $stoodle->end_date > time()): ?>
    <form action="<?= $controller->url_for('stoodle/comment', $stoodle->stoodle_id) ?>" method="post">
        <?= CSRFProtection::tokenTag() ?>
        <fieldset>
            <legend><?= _('Kommentar hinzuf�gen') ?></legend>

            <div class="type-text">
                <textarea class="add_toolbar" name="comment"></textarea>
            </div>

            <?= Studip\Button::createAccept(_('Kommentar speichern'), 'store') ?>
        </fieldset>
    </form>
<? endif; ?>
<? if (!empty($stoodle->comments)): ?>
    <table class="default zebra">
        <colgroup>
            <col width="<?= reset(Avatar::getDimension(Avatar::SMALL)) ?>">
            <col>
        </colgroup>
        <tbody>
        <? foreach (array_slice($stoodle->comments, 0, $limit) as $comment):
            $user = User::find($comment->user_id);
        ?>
            <tr>
                <td>
                    <a href="<?= URLHelper::getLink('about.php?username=' . $user->username, array('cid' => null)) ?>">
                        <?= Avatar::getAvatar($comment->user_id)->getImageTag(Avatar::SMALL) ?>
                    </a>
                </td>
                <td>
                    <?= formatReady($comment->comment) ?>

                    <ul class="details">
                        <li><?= date('d.m.y H:i', $comment->mkdate) ?></li>
                        <li>
                            <a href="<?= URLHelper::getURL('about.php?username=' . $user->username, array('cid' => null)) ?>">
                                <?= $user->getFullName() ?>
                            </a>
                        </li>
                    <? if ($comment->user_id == $GLOBALS['user']->id
                        || $GLOBALS['perm']->have_perm('root')
                        || $GLOBALS['perm']->have_studip_perm('tutor', $range_id)):
                        
                    ?>
                        <li>
                            <a href="<?= $controller->url_for('stoodle/delete_comment', $comment->comment_id) ?>">
                                <?= Assets::img('icons/16/blue/trash', array('class' => 'text-top') + tooltip2(_('Kommentar l�schen'))) ?>
                            </a>
                        </li>
                    <? endif; ?>
                    </ul>
                </td>
            </tr>
        <? endforeach; ?>
        <? if (($spillover = count($stoodle->comments) - $limit) > 0): ?>
            <tr class="more-comments">
                <td colspan="2" class="topic">
                    <a href="<?= $controller->url_for('stoodle', $stoodle->stoodle_id, 'all') ?>#comments">
                        <?= Assets::img('icons/16/white/arr_1down') ?>
                        <? if ($spillover == 1): ?>
                            <?= _('1 weiterer Kommentar') ?>
                        <? else: ?>
                            <?= sprintf(_('%u weitere Kommentare...'), $spillover) ?> 
                        <? endif; ?>
                    </a>
                </td>
            </tr>
        <? endif; ?>
        </tbody>
    </table>
<? endif; ?>
</div>
