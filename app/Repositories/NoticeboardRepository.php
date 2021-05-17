<?php

namespace App\Repositories;

use App\Mail\NewsLetterMail;
use App\Models\NewsLetter;
use App\Models\Noticeboard;
use Exception;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class NoticeboardRepository
 */
class NoticeboardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Noticeboard::class;
    }

    /**
     * @param $input
     *
     *
     * @return bool
     */
    public function store($input)
    {
        /* @var  Noticeboard $noticeboard */
        $noticeboard = $this->create($input);

        $newsLetterEmails = NewsLetter::pluck('email')->toArray();

        foreach ($newsLetterEmails as $key => $newsLetterEmail) {
            try {
                Mail::to($newsLetterEmail)
                    ->send(new NewsLetterMail('emails.news_letter.news_letter',
                        $input['title'],
                        $input));

            } catch (Exception $e) {
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        }

        return true;
    }
}
