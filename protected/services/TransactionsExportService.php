<?php

class TransactionsExportService
{
    private static function preparePdf()
    {
        Yii::import('application.ext.mpdf.mpdf');
        $mpdf = new mpdf('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
        $mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

        $stylesheet = file_get_contents(Yii::app()->getBaseUrl(true) . '/css/pdf/style.css'); /*подключаем css*/
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->list_indent_first_level = 0;
        return $mpdf;
    }

    /**
     * @param string $html
     * @param Form_Search $model
     * @param string $fileName
     */
    public static function exportListPdf($html, $model, $fileName)
    {
        $mpdf = self::preparePdf();
        $start_date = date('d M Y', strtotime($model->from_date));
        $end_date = ($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time());

        $mpdf->SetHtmlFooter('<div class="pdf-footer">
				<table class="footer-info">
					<tr>
						<td width="25%" class="left">Xabina</td>
						<td width="35%">' . $start_date . ' - ' . $end_date . '</td>
						<td width="30%">' . date('d.m.Y H:i:s', time()) . '</td>
						<td width="10%" class="right">{PAGENO}/{nbpg}</td>
					</tr>
				</table>
			</div>');
        $mpdf->WriteHTML($html, 2); /*формируем pdf*/

        $mpdf->Output($fileName, 'I');
    }

    /**
     * @param string $html
     * @param string $fileName
     */
    public static function exportDetailPdf($html, $fileName)
    {
        $mpdf = self::preparePdf();
        $mpdf->SetHtmlFooter('<div class="pdf-footer">
                        <table class="footer-info">
                            <tr>
                                <td width="25%" class="left">Xabina</td>
                                <td width="30%">' . date('d.m.Y H:i:s', time()) . '</td>
                                <td width="10%" class="right">{PAGENO}/{nbpg}</td>
                            </tr>
                        </table>
                    </div>');
        $mpdf->WriteHTML($html, 2); /*формируем pdf*/

        $mpdf->Output($fileName, 'I');
    }

    /**
     * @param array $header
     * @param array $data
     * @param string $filename
     * @return string
     */
    public static function writeTableToCsvFile($header, $data, $filename)
    {
        $filePath ='/tmp/'.uniqid().$filename;
        $handle = fopen($filePath, 'w+');
        fputcsv($handle, array_values($header), ";", "\"");
        foreach ($data as $value) {
            $line = array();
            foreach ($header as $key => $title) {
                $line[] = $value[$key];
            }
            fputcsv($handle, $line, ";", "\"");
        }
        fclose($handle);
        return $filePath;
    }

    /**
     * @param PHPWord_Template $document
     * @param Form_Search $model
     * @param Users $user
     */
    private static function fillHeaderDocTemplate(&$document, $model=null, $user=null)
    {
        if($model) {
            $periodVal =date('d M', strtotime($model->from_date)) .' - '.(($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time()));
            $document->setValue('periodVal', $periodVal);
        }

        // translate for info table
        $document->setValue('Account_Statement', Yii::t('Front', 'Account Statement'));
        $document->setValue('client', Yii::t('Front', 'Client').':');
        $document->setValue('address', Yii::t('Front', 'Address').':');
        $document->setValue('reg', Yii::t('Front', 'Reg #').':');
        $document->setValue('account_number_IBAN', Yii::t('Front', 'Account number IBAN').':');
        $document->setValue('periodFilter', Yii::t('Front', 'Period').':');
        $document->setValue('transactionsFilter', Yii::t('Front', 'Transactions').':');

        if($model) {
            $document->setValue('sumFilter', ($model->from_sum != '' || $model->to_sum != '') ? (Yii::t('Front', 'Sum').':') : '');
            $document->setValue('keywordFilter', ($model->keyword != '') ? (Yii::t('Front', 'Keyword').':') : '');
        }

        // values for info table
        if($user) {
            $document->setValue('clientVal', $user->fullname);
        }
        $document->setValue('addressVal', $user->primary_address ? $user->primary_address->shortAddressHtml : '');
        $document->setValue('regVal', '2546897');
        $document->setValue('IBANVal', '254897546212');

        if($model) {
            $document->setValue('transactionsVal', ($model->type ? Yii::t('Front', ucfirst($model->type)) : Yii::t('Front', 'All')));
            $document->setValue('sumVal', ($model->from_sum != '' || $model->to_sum != '') ?
                    (
                        (($model->from_sum != '') ? Yii::t('Front', 'from') .' '. $model->from_sum:'') .
                        (($model->to_sum != '') ? Yii::t('Front', 'to') .' '. $model->to_sum:'')
                    ) : '');
            $document->setValue('keywordVal', $model->keyword);
        }
    }

    /**
     * @param Transactions $trans
     * @return string
     */
    public static function exportDetailDoc($trans)
    {
        $includePath = Yii::getPathOfAlias('application.vendor.phpWord');
        $tmplPath = Yii::getPathOfAlias('application.views.accounts.transaction');
        spl_autoload_unregister(array('YiiBaseEx', 'autoload'));
        require_once $includePath.'/PHPWord.php';

        $PHPWord = new PHPWord();

        spl_autoload_register(array('YiiBaseEx', 'autoload'));

        $document = $PHPWord->loadTemplate($tmplPath.'/transaction_template.docx');

        self::fillHeaderDocTemplate($document, null, Users::model()->with('primary_address')->findByPk(Yii::app()->user->id));

        $document->setValue('headerText', Yii::t('Front', 'Indepland - Details overschrijving'));

        $detailTable = array(
            'label' => array(),
            'value' => array()
        );
        foreach($trans->info->getPublicAttrs() as $label => $value) {
            $detailTable['label'][] = $label;
            $detailTable['value'][] = $value;
        }
        $document->cloneRow('detailTable', $detailTable);

        // footer
        $document->setValue('nowDateVal', date('d.m.Y H:i:s'));

        $fileName = Yii::getPathOfAlias('application.runtime').'/transactions_'.md5(serialize($trans)).'.docx';
        $document->save($fileName);
        return $fileName;
    }

    /**
     * @param Form_Search $model
     * @param Accounts $account
     * @param Transactions[] $transactions
     * @return string
     */
    public static function exportListDoc($model, $account, $transactions)
    {
        $includePath = Yii::getPathOfAlias('application.vendor.phpWord');
        $tmplPath = Yii::getPathOfAlias('application.views.accounts.cardbalance');
        spl_autoload_unregister(array('YiiBaseEx', 'autoload'));
        require_once $includePath.'/PHPWord.php';

        $PHPWord = new PHPWord();

        spl_autoload_register(array('YiiBaseEx', 'autoload'));

        $document = $PHPWord->loadTemplate($tmplPath.'/cardbalance_template.docx');

        self::fillHeaderDocTemplate($document, $model, Users::model()->with('primary_address')->findByPk(Yii::app()->user->id));

        $debit = 0;
        $credit = 0;
        $transactionsTable = array(
            'date' => array(),
            'type' => array(),
            'detailsSender' => array(),
            'detailsExtra' => array(),
            'sumInc' => array(),
            'sumDec' => array(),
            'balance' => array(),
        );
        foreach($transactions as $trans){
            $transactionsTable['date'][] = date('d.m.Y', $trans->created_at);
            $transactionsTable['type'][] = $trans->info->type;
            $transactionsTable['detailsSender'][] = $trans->info->sender;
            $transactionsTable['detailsExtra'][] = $trans->info->details_of_payment;
            $transactionsTable['balance'][] = number_format($trans->acc_balance, 2, ".", " ");

            if($trans->type == 'positive'){
                $transactionsTable['sumInc'][] = number_format($trans->sum, 2, ".", " ") . $trans->account->currency->code;
                $transactionsTable['sumDec'][] = '';
                $credit = $credit + $trans->sum;
            } else if($trans->type == 'negative'){
                $transactionsTable['sumDec'][] = '-' . number_format($trans->sum, 2, ".", " ") . $trans->account->currency->code;
                $transactionsTable['sumInc'][] = '';
                $debit = $debit + $trans->sum;
            }
        }

        // headers for balance table
        $document->setValue('currency', Yii::t('Front', 'Currency'));
        $document->setValue('balanceStarting', Yii::t('Front', 'Balance at the starting date'));
        $document->setValue('balanceEnding', Yii::t('Front', 'Balance at the ending date'));
        $document->setValue('credit', Yii::t('Front', 'Credit turnover'));
        $document->setValue('debit', Yii::t('Front', 'Debit turnover'));
        // values for balance table
        $document->setValue('currencyVal', $account->currency->code);
        $balanceStart = count($transactions) ?
            reset($transactions)->acc_balance - reset($transactions)->sum :
            (isset($account->transactions[0]) ? $account->transactions[0]->acc_balance : 0);
        $balanceEnd = count($transactions) ?
            end($transactions)->acc_balance :
            (isset($account->transactions[0]) ? $account->transactions[0]->acc_balance : 0);
        $document->setValue('balanceStartingVal', number_format($balanceStart, 2, ".", " "));
        $document->setValue('balanceEndingVal', number_format($balanceEnd, 2, ".", " "));
        $document->setValue('creditVal', $credit);
        $document->setValue('debitVal', $debit);

        // headers for transactions table
        $document->setValue('date', Yii::t('Front', 'Date'));
        $document->setValue('type', Yii::t('Front', 'Type'));
        $document->setValue('details', Yii::t('Front', 'Details'));
        $document->setValue('sum', Yii::t('Front', 'Sum'));
        $document->setValue('balance', Yii::t('Front', 'Balance'));

        if(count($transactions) == 0) {
            $document->removeRow('transactionsTable');
            $document->setValue('noTransactions.val', Yii::t('Front', 'No transactions meet the filter criterias'));
        } else {
            $document->cloneRow('transactionsTable', $transactionsTable);
            $document->removeRow('noTransactions');
        }

        // footer
        $document->setValue('nowDateVal', date('d.m.Y H:i:s'));

        $fileName = Yii::getPathOfAlias('application.runtime').'/transactions_'.md5(serialize($model)).'.docx';
        $document->save($fileName);
        return $fileName;
    }
} 