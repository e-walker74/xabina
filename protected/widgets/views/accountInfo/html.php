<?= $account->user->fullName ?>
<?= str_repeat("&nbsp;", 16) ?>                    
<?= chunk_split($account->number, 4) ?>
<?= str_repeat("&nbsp;", 16) ?>
<?= number_format($account->balance, 0, "", " ") ?>
<?= $account->currency->title ?>