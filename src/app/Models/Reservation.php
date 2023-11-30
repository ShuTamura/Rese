<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shop_id', 'date', 'time', 'number', 'payment'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function shop() {
        return $this->belongsTo('App\Models\Shop');
    }

    public function qrCode($url) {

        // QrCodeオブジェクトを生成して各種オプションを設定
        $qrCode = QrCode::create($url)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(150)
                    ->setMargin(25)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0));

        // PngWriterオブジェクトを生成し、QrCodeオブジェクトの情報を書き込む
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Base64でエンコード
        $qrCodeBase64 = base64_encode($result->getString());

        // QRコードのimgタグを生成してスタイル属性でサイズを設定
        $qrCodeImg = '<img src="data:image/gif;base64,'.$qrCodeBase64.'" alt="QR Code" style="width:400px;">';

        // QRコードを画面に表示
        echo $qrCodeImg;
    }
}
