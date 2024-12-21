<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 发送验证码
 *
 * @author KanekiYuto
 */
class IdentifyingCode extends Mailable
{

    use Queueable, SerializesModels;

    /**
     * 验证码
     *
     * @var int
     */
    private int $code;

    /**
     * 有效期
     *
     * @var int
     */
    private int $validity;

    /**
     * 创建一个新的消息实例
     *
     * @return void
     */
    public function __construct(
        string $subject,
        int $code,
        int $validity
    ) {
        $this->subject = $subject;
        $this->code = $code;
        $this->validity = $validity;
    }

    /**
     * 构建消息
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('identifying-code', [
            'code' => $this->code,
            'validity' => $this->validity,
        ])->subject($this->subject);
    }

}
