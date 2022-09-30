<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Make Procedure
        $str = <<<EOD
        CREATE PROCEDURE countLeads(IN p1 DATE, IN p2 DATE)
        BEGIN
        SELECT users.id, users.firstname, users.lastname,
        COUNT(*) as CountLeads,
        COUNT(IF(leads.isQualityLead='1', 1, null)) as CountQualityLeads,
        COUNT(IF(leads.isQualityLead='1' and    leads.is_add_sale='1', 1, null)) as CountQualityAddSales,
        COUNT(IF(leads.isQualityLead='0', 1, null)) as CountNotQualityLead,
        COUNT(IF(leads.isQualityLead='0' and leads.is_add_sale='0', 1, null)) as CountNotQualityAddSalesLead
        FROM leads
        LEFT JOIN users ON (leads.user_id = users.id)
        WHERE leads.created_at >= p1 and leads.created_at <= p2 AND leads.status_id = 3
        GROUP BY users.id, users.firstname, users.lastname;
        END

        EOD;

        \Illuminate\Support\Facades\DB::unprepared($str);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
