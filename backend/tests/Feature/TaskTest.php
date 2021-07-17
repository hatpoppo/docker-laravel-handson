<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    //テストケースごとにマイグレーションを再実行する
    use RefreshDatabase;
    /**
     * 各テストメソッドの実行前に呼ばれる
     */
    public function setUp(): void
    {
        parent::setUp();
        //テストケース実行前にフォルダデータを作成する
        $this->seed('FoldersTableSeeder');
    }
    /**
     * 期限日が日付でない場合
     * @test
     */
    public function due_date_should_date()
    {
        $response = $this->post('/folders/1/tasks/create',[
            'title' => 'Sample task',
            'due_date' => 123, //不正な値
        ]);

        // var_dump($response);
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力して下さい。'
        ]);
    }
    /**
     * 期限日が過去日付の場合
     * @test
     */
    
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create',[
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d') , //不正な値
        ]);
        // $response->dumpSession();
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力して下さい。'
        ]);
    }
    /**
     * 状態が定義された値でない
     * @test
     */
    public function status_should_be_within_defined_numbers()
    {
        $this->seed('TasksTableSeeder');
        $response = $this->post('/folders/1/tasks/1/edit', [
            'title' => 'Sample Task',
            'due_date' => Carbon::today()->format('Y/m/d') , 
            'status' => 999,
        ]);
        // $response->dumpSession();
        $response->assertSessionHasErrors([
            'status' => '状態 には未着手、着手中、完了のいずれかを指定してください。',
        ]);
    }

}
