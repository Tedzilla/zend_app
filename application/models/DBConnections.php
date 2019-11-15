<?php
class notoria_Model_DBConnections extends Localui_Db_Table_Abstract
{
    private $dbPlQuotes;
    
    public function __construct(){
        
        $this->dbPlQuotes = Zend_Registry::get('db_pl_quotes');
        
    }
    
    public function getQuote($country="PL", $instrument_type_code="", $instrument_subtype_code="", $order_by="name"){
        
        $select = $this->dbPlQuotes->select()
            ->from('quote')
            ->order($order_by)
            ->limit(10);
        
        if (!empty($country)) {
            $select->where("country_code='$country'");
        }
        if (!empty($instrument_type_code)) {
            $select->where("instrument_type_code='$instrument_type_code'");
        }
        if (!empty($instrument_subtype_code)) {
            $select->where("instrument_subtype_code='$instrument_subtype_code'");
        }
        
        $data = $this->dbPlQuotes->fetchAll($select);
        $data['data_type'] = 'Quote';
        
        return $data;
    }
    
    public function getMarketSegment($country="PL"){

        $select = $this->dbPlQuotes->select()
                ->from('market_segment')
                ->order('name');
        
        if (!empty($country)) {
            $select->where("country_code='$country'");
        }
        $sql= $select->__toString();
        
        $data = $this->dbPlQuotes->fetchAll($select);
        $data['data_type'] = 'Market Segment';
        
        return $data;
    }
    
    public function getInstrument(){
        
        $select = $this->dbPlQuotes->select()
            ->from('instrument_type')
            ->order('name_id');
        
        if (!empty($where)) {
            $select->where($where);
        }
        
        $data = $this->dbPlQuotes->fetchAll($select);
        $data['data_type'] = 'Instrument';
        
        return $data;
    }
    
    public function getInstrumentTypeCodes(){
        
        $select = $this->dbPlQuotes->select()
            ->distinct()
            ->from(array('i' => 'instrument_type'),
                    array('instrument_type_code'))
            ->order('instrument_type_code ASC');
        
        $data = $this->dbPlQuotes->fetchAll($select);
        
        return $data;
    }
        
    public function getDpCodes(){
        
        $select = $this->dbPlQuotes->select()
            ->distinct()
            ->from(array('i' => 'DP'),
                    array('dp_code'))
            ->order('dp_code ASC');
        
        $data = $this->dbPlQuotes->fetchAll($select);
        
        return $data;
    }
    
    public function getMarketSegmentTypeCodes(){
        
        $select = $this->dbPlQuotes->select()
            ->distinct()
            ->from(array('i' => 'market_segment'),
                    array('market_segment_code'))
            ->order('market_segment_code ASC');
        
        $data = $this->dbPlQuotes->fetchAll($select);
        
        return $data;
    }
    
    public function getInstrumentSubTypeCodes($main_type=""){
        
        $select = $this->dbPlQuotes->select()
            ->distinct()
            ->from(array('i' => 'instrument_type'),
                    array('instrument_subtype_code'))
            ->order('instrument_subtype_code ASC');
        
        if (!empty($main_type)) {
            $select->where($main_type);
        }
        #$sql= $select->__toString();
        #echo "sql ==== " . $sql;
        $data = $this->dbPlQuotes->fetchAll($select);
        
        return $data;
    }
    
    public function getLastQuoteId(){
        $select = $this->dbPlQuotes->select()
                ->from('quote',array('MAX(quote_id)'));
        $data = $this->dbPlQuotes->fetchAll($select);
        
        return $data;
    }
}
