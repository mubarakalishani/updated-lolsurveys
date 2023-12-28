<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\ShortLinksHistory;

class ShortLinksHistoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ShortLinksHistory';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShortLinksHistory());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('link_id', __('Link id'));
        $grid->column('reward', __('Reward'));
        $grid->column('ip_address', __('Ip address'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ShortLinksHistory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('link_id', __('Link id'));
        $show->field('reward', __('Reward'));
        $show->field('ip_address', __('Ip address'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ShortLinksHistory());

        $form->number('user_id', __('User id'));
        $form->number('link_id', __('Link id'));
        $form->decimal('reward', __('Reward'))->default(0.0000);
        $form->text('ip_address', __('Ip address'));

        return $form;
    }
}
