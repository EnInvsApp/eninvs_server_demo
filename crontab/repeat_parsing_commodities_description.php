<?php

$apikey = '**********';

$comm_links = 
[
	['commID' => 8,   'source' => 'fmp', 'link' => 'https://financialmodelingprep.com/api/v3/quote/PLUSD?apikey='.$apikey], 
	['commID' => 9,   'source' => 'fmp', 'link' => 'https://financialmodelingprep.com/api/v3/quote/PAUSD?apikey='.$apikey], 
	['commID' => 10,  'source' => 'fmp', 'link' => 'https://financialmodelingprep.com/api/v3/quote/HGUSD?apikey='.$apikey], 
	['commID' => 13,  'source' => 'fmp', 'link' => 'https://financialmodelingprep.com/api/v3/quote/ZIUSD?apikey='.$apikey], 
	
	['commID' => 41,  'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Liquid-ammonia-965.html'], 
	['commID' => 43,  'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Ammonium-nitrate-967.html'], 
	['commID' => 47,  'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Sulfur-427.html'], 
	['commID' => 48,  'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Potassium-chloride-759.html'], 
	['commID' => 107, 'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Natural-rubber-586.html'], 
	['commID' => 146, 'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Polyamide-DTY-910.html'], 
	['commID' => 167, 'source' => 'sun', 'link' => 'http://www.sunsirs.com/commodity-price/petail-Caustic-soda-368.html'], 
	
	['commID' => 14,  'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/aluminum'], 
	['commID' => 15,  'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/brent-crude-oil'], 
	['commID' => 83,  'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/lead'], 
	['commID' => 84,  'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/zinc'], 
	['commID' => 133, 'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/rhodium'], 
	['commID' => 161, 'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/bitumen'], 
	['commID' => 174, 'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/ethanol'], 
	['commID' => 183, 'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/soybeans'], 
	['commID' => 185, 'source' => 'trc', 'link' => 'https://tradingeconomics.com/commodity/uranium'], 
	
	['commID' => 11,  'source' => 'inv', 'link' => 'https://advcharts.investing.com/advinion2016/advanced-charts/7/7/18/GetRecentHistory?strSymbol=959208&iTop=1500&strPriceType=bid&strFieldsMode=allFields&strExtraData=lang_ID=7&strTimeFrame=1M'], 
	['commID' => 77,  'source' => 'inv', 'link' => 'https://advcharts.investing.com/advinion2016/advanced-charts/7/7/18/GetRecentHistory?strSymbol=1168084&iTop=1500&strPriceType=bid&strFieldsMode=allFields&strExtraData=lang_ID=7&strTimeFrame=1M'], 
	['commID' => 168, 'source' => 'inv', 'link' => 'https://advcharts.investing.com/advinion2016/advanced-charts/1/1/8/GetRecentHistory?strSymbol=1152740&iTop=1500&strPriceType=bid&strFieldsMode=allFields&strExtraData=lang_ID=1&strTimeFrame=1M'], 
	['commID' => 187, 'source' => 'inv', 'link' => 'https://advcharts.investing.com/advinion2016/advanced-charts/1/1/8/GetRecentHistory?strSymbol=8849&iTop=1500&strPriceType=bid&strFieldsMode=allFields&strExtraData=lang_ID=1&strTimeFrame=1M'], 
	['commID' => 201, 'source' => 'inv', 'link' => 'https://advcharts.investing.com/advinion2016/advanced-charts/7/7/18/GetRecentHistory?strSymbol=940798&iTop=1500&strPriceType=bid&strFieldsMode=allFields&strExtraData=lang_ID=7&strTimeFrame=1W'], 
	
	['commID' => 90,  'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/APU0000706111'], 
	['commID' => 162, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/WPU0652026A'], 
	['commID' => 164, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU32733273'], 
	['commID' => 166, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU325211325211'], 
	['commID' => 171, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/ZAFCPIENGQINMEI'], 
	['commID' => 179, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SETA02'], 
	['commID' => 180, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUUR0000SETA01'], 
	['commID' => 184, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SETG01'], 
	['commID' => 191, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/IC131'], 
	['commID' => 192, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU486110486110'], 
	['commID' => 193, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU4869104869101'], 
	['commID' => 206, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/WPU02210503'], 
	['commID' => 215, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU33613361'], 
	['commID' => 218, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CPIAPPSL'], 
	['commID' => 219, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUUR0000SAM1'], 
	['commID' => 220, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SEGA'], 
	['commID' => 221, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SAH1'], 
	['commID' => 222, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUUR0000SEHA'], 
	['commID' => 223, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SEHC'], 
	['commID' => 224, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU621111621111'], 
	['commID' => 225, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUUR0000SEMD'], 
	['commID' => 226, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SETD'], 
	['commID' => 227, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU52421052421010101'], 
	['commID' => 229, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU5241265241263'], 
	['commID' => 230, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SEHF02'], 
	['commID' => 231, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SEHF01'], 
	['commID' => 232, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SEHG'], 
	['commID' => 233, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/PCU334334'], 
	['commID' => 234, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/CUSR0000SEEE01'], 
	['commID' => 235, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/WPU43110101'],
	['commID' => 236, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/WPU431104'],
	['commID' => 237, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/WPU431103'],
	['commID' => 238, 'source' => 'frd', 'link' => 'https://fred.stlouisfed.org/series/WPU431102'],
	
	['commID' => 12,  'source' => 'mbi', 'link' => 'https://markets.businessinsider.com/commodities/gold-price'], 
	['commID' => 63,  'source' => 'mbi', 'link' => 'https://markets.businessinsider.com/commodities/tin-price'], 
	
	['commID' => 181, 'source' => '181', 'link' => 'https://www.eia.gov/petroleum/gasdiesel'], 
	['commID' => 182, 'source' => '182', 'link' => 'https://www.eia.gov/petroleum/gasdiesel'], 
	['commID' => 186, 'source' => '186', 'link' => 'https://www.eia.gov/dnav/pet/hist/EER_EPJK_PF4_RGC_DPGD.htm'], 
	
	['commID' => 197, 'source' => 'est', 'link' => 'https://restate.ru/action/graph2/data/?region=2&type=1&period=4&money=r'], 
	['commID' => 198, 'source' => 'est', 'link' => 'https://restate.ru/action/graph2/data/?region=2&type=1&period=4&money=r'], 
	['commID' => 199, 'source' => 'est', 'link' => 'https://restate.ru/action/graph2/data/?region=1&type=1&period=4&money=r'], 
	['commID' => 200, 'source' => 'est', 'link' => 'https://restate.ru/action/graph2/data/?region=1&type=1&period=4&money=r'], 
	
	['commID' => 202, 'source' => 'sab', 'link' => 'https://shipandbunker.com/prices/av/region/av-am-americas-average'], 
	['commID' => 203, 'source' => 'sab', 'link' => 'https://shipandbunker.com/prices/av/global/av-g20-global-20-ports-average'], 
	['commID' => 204, 'source' => 'sab', 'link' => 'https://shipandbunker.com/prices/emea/nwe/nl-rtm-rotterdam'], 
	['commID' => 205, 'source' => 'sab', 'link' => 'https://shipandbunker.com/prices/apac/ea/cn-hok-hong-kong'], 
	
	// ---------------------------
	
	['commID' => 22,  'source' => 'ppf', 'link' => 'https://www.petrolplus.ru/fuelindex'], 
	
	['commID' => 24,  'source' => 'pps', 'link' => 'https://www.petrolplus.ru/fuelindex/st._petersburg/'], 
	
	['commID' => 88,  'source' => 'ulc', 'link' => 'https://usda.library.cornell.edu/concern/publications/br86b359j'], 
	
	['commID' => 94,  'source' => 'cme', 'link' => 'https://www.cmegroup.com/CmeWS/mvc/Quotes/ContractsByNumber?productIds=444&contractsNumber=1&venue=G'], 
	
	['commID' => 118,  'source' => 'dat', 'link' => 'https://www.dat.com/trendlines/van/national-rates'], 
	
	// не применять к другим ценам с theice, в функции значение умножается на 10.5 (2022-06-06)
	['commID' => 123, 'source' => 'ice', 'link' => 'https://www.theice.com/marketdata/DelayedMarkets.shtml?getContractsAsJson=&productId=4331&hubId=7979'], 
	
	['commID' => 170, 'source' => 'sag', 'link' => 'https://www.stonealgo.com/diamond-prices/1.1-carat-emerald-cut-diamond-prices/'], 
	
	['commID' => 173, 'source' => 'fnm', 'link' => 'https://www.tinkoff.ru/invest/currencies/GLDRUB_TOM/'], 
	
	['commID' => 176, 'source' => 'ech', 'link' => 'https://www.echemi.com/productsInformation/temppid160705011796-ammonium-sulfate.html'], 
	
	['commID' => 190, 'source' => 'fzp', 'link' => 'https://fertilizerpricing.com/wp-content/themes/greenmarkets/fcharts/fchart_lib/json/data_open.php'], 
	
	['commID' => 195,  'source' => 'dia', 'link' => 'http://www.idexonline.com/diamond_prices_index'], 
	
	[
		'commID' => 228, 
		'source' => 'cgr', 
		'link' => 
			'https://www.cargurus.com/Cars/price-trends/priceIndexJson.action?startDate='.
			date('m', strtotime('-10 days')).
			'/'.
			date('d', strtotime('-10 days')).
			'/'.
			date('Y', strtotime('-10 days')).
			'&entityIds=Index'
	], 
	
];

?>