<?php

class Notoria_IndexController extends Localui_Controller_Base {
    private $quoteDB;
    
    public function init() {
        parent::init();
        $this->quoteDB = new notoria_Model_DBConnections();
    }

    public function indexAction() {
        $request = $this->getRequest();
        $this->view->country = "PL";
        
        if ($request->getParam('country')) {
            $this->view->country = $request->getParam('country');
        }

        $sorting_arr = explode('&', $request->getParam('sort_by'));
        $this->view->active_instrument_subtype = $sorting_arr[2];
        $this->view->active_instrument_type = $sorting_arr[1];
        $this->view->quote = $this->quoteDB->getQuote($this->view->country, $sorting_arr[1], $sorting_arr[2], $sorting_arr[0]);
        
        $this->view->instruments = $this->quoteDB->getInstrumentTypeCodes();
        
        if ($request->getParam('instruments_type_search')) {
            $this->view->active_instrument_type = $request->getParam('instruments_type_search');
            if(isset($this->view->active_instrument_type)){
                $this->view->instrument_type_filtered = $this->quoteDB->getQuote($this->view->country, $this->view->active_instrument_type, "", $this->view->sort_by);
            }
            $this->view->instrument_subtype = $this->quoteDB->getInstrumentSubTypeCodes("instrument_type_code='".$this->view->active_instrument_type."'");
        } else {
            $this->view->instrument_subtype = $this->quoteDB->getInstrumentSubTypeCodes();
        }
        
        
        if ($request->getParam('instruments_subtype_search')){
            $this->view->active_instrument_subtype = $request->getParam('instruments_subtype_search');
            if(isset($this->view->active_instrument_subtype)){
                $this->view->instrument_subtype_filtered = $this->quoteDB->getQuote($this->view->country, "", $this->view->active_instrument_subtype, $this->view->sort_by);
            }
        }
        
    }
    
    public function marketAction(){
        $request = $this->getRequest();
        
        if ($request->getParam('country')) {
            $this->view->country = $request->getParam('country');
            $this->view->market = $this->quoteDB->getMarketSegment($this->view->country);
        } else {
            $this->view->market = $this->quoteDB->getMarketSegment("PL");
        }

    }

    public function instrumentAction(){
        $this->view->instrument = $this->quoteDB->getInstrument();
    }
    
    public function newAction(){
        $last_quote_arr = $this->quoteDB->getLastQuoteId();
        $this->view->lastQuote = implode('', $last_quote_arr[0]);
        $this->view->lastQuote++;
        $this->view->marketCode = $this->quoteDB->getMarketSegmentTypeCodes("");
        $this->view->instrumentCode = $this->quoteDB->getInstrumentTypeCodes();
        $this->view->instrumentSubtypeCode = $this->quoteDB->getInstrumentSubTypeCodes();
        $this->view->dpCodes = $this->quoteDB->getDpCodes();
    }
    
    public function editquoteAction(){
     
        # $request = $this->getRequest();
        #if ($request->getParam('edit')){
        #    print_r("PARAM IS ===== " . var_dump($request->getParam('edit')));
        #}
        $this->addNewQuote = new notoria_Model_DBConnections();
        $this->view->addNewQuote = $this->market_segmentDB->getMarketSegment("");
    }
}
