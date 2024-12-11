<?php
namespace App\Services;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class StaticsService
{

    /**
     * 정당별 의원현황
     * @return array
     */
    public function getPartyMembers($termId)
    {
        $result = DB::select("SELECT
                                party_id,
                                (SELECT name FROM parties WHERE id = member_term.party_id) AS party_name,
                                COUNT(*) AS party_count
                            FROM member_term WHERE term_id = ?
                            GROUP BY party_id
                            ", [$termId]);
        return $result;
    }

    /**
     * 당선횟수별 의원현황
     * @return array
     */
    public function getTermNumbers($termId)
    {
        $result = DB::select("SELECT
                                        term_count,
                                        COUNT(*) AS member_count
                                    FROM (
                                        SELECT
                                            member_id,
                                            COUNT(*) AS term_count
                                        FROM member_term
                                            WHERE member_id IN (
                                                SELECT member_id FROM member_term WHERE term_id = ?
                                                )
                                        GROUP BY member_id
                                    ) AS A GROUP BY term_count", [$termId]);
        return $result;
    }

    /**
     * 성별 의원현황
     * @return array
     */
    public function getGenders($termId)
    {
        return DB::select("
            SELECT
                gender, COUNT(*) AS gender_cnt
            FROM members WHERE id IN (SELECT member_id FROM member_term WHERE term_id = ?)
            GROUP BY gender
        ", [$termId]);
    }

    /**
     * 연령별 의원현황
     * @return array
     */
    public function getAgeGroups($termId)
    {
        return DB::SELECT(
            "
                    SELECT age_group,
                           COUNT(*) AS age_group_cnt
                    FROM (SELECT *,
                                 CASE
                                     WHEN age BETWEEN 10 AND 19 THEN '10대'
                                     WHEN age BETWEEN 20 AND 29 THEN '20대'
                                     WHEN age BETWEEN 30 AND 39 THEN '30대'
                                     WHEN age BETWEEN 40 AND 49 THEN '40대'
                                     WHEN age BETWEEN 50 AND 59 THEN '50대'
                                     WHEN age BETWEEN 60 AND 69 THEN '60대'
                                     WHEN age BETWEEN 70 AND 79 THEN '70대'
                                     ELSE '70대 이상'
                                     END AS age_group
                          FROM (SELECT *,
                                       (SELECT TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) -
                                               (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birth_date, '%m%d'))) AS age
                                FROM members
                                WHERE id IN (SELECT member_id FROM member_term WHERE term_id = ?)) AS A) AS B
                    GROUP BY age_group
                    ", [$termId]);
    }
}
