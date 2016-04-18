<?php

namespace TypiCMS\Modules\History\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use TypiCMS\Modules\History\Repositories\HistoryInterface;

class VersioningComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    // protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(HistoryInterface $historable)
    {
        // Dependencies automatically resolved by service container...
        // $this->users = $users;
        dd($historable);
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('alabala', 2);
    }
}
