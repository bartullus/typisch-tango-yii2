/**
 * Author:  herbert
 * Created: 12.11.2018
 */

SELECT article_id, newsletter_id, count(*) as cnt 
FROM `tt_newsletter_send`
GROUP BY article_id, newsletter_id
HAVING count(*) > 1
ORDER BY article_id, newsletter_id
LIMIT 500
