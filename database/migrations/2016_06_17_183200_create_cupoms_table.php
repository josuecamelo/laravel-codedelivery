<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupomsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cupoms', function (Blueprint $table) {
			$table->increments('id');
			$table->string('code');
			$table->decimal('value');
			$table->boolean('used')->default(0);
			$table->timestamps();
		});

		//alterando tabela de orders
		Schema::table('orders', function(Blueprint $table){
			$table->integer('cupom_id')->unsigned()->nullable();
			$table->foreign('cupom_id')->references('id')->on('cupoms'); //na tabela orders terá agora campos cupom_id
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table){
			$table->dropForeign('orders_cupom_id_foreign');//dropando fk e coluna cupom_id de pedidos
			$table->dropColumn('cupom_id');
		});
		Schema::drop('cupoms');
	}
}
