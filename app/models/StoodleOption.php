<?
class StoodleOption extends SimpleORMap
{
    /**
     *
     * @param string $id primary key of table
     */
    function __construct($id = null)
    {
        $this->db_table = 'stoodle_options';
        parent::__construct($id);
    }

    public function getNewId()
    {
        return md5(uniqid('stoodle-option', true));
    }

    public function setResult($state)
    {
        $query = "UPDATE stoodle_options SET result = ? WHERE option_id = ?";
        $statement = DBManager::get()->prepare($query);
        $statement->execute(array(
            (int)$state, $this->option_id
        ));
    }

    public static function findByStoodle($stoodle_id)
    {
        $query = "SELECT option_id FROM stoodle_options WHERE stoodle_id = ? ORDER BY position";
        $statement = DBManager::get()->prepare($query);
        $statement->execute(array($stoodle_id));
        $ids = $statement->fetchAll(PDO::FETCH_COLUMN);

        return array_combine($ids, array_map('self::find', $ids));
    }
}
