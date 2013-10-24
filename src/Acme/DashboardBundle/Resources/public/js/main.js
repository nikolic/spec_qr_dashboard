var Dashboard = function(){
  var self = this;

  this.loadedPartsCount = 0;

  this.init = function(){

    this.LoadPart(CREATE_QR_PATH, $("#code_generator"));
    this.LoadPart(STATISTICS_PATH, $("#statistics_and_reports"), self.onLoadedStatistics);

  }

  this.LoadPart = function(path, selector, callback){
      $.ajax({
        type: "GET",
        url: path,
        dataType: "text",
        success: function(html){
          selector.html(html);
          self.loadedPartsCount += 1;
          if(callback){
            callback();
          }
        },
        error : function(err){
          selector.html("error");
        }
      });
  }

  this.onLoadedStatistics = function(){
    var statistics = new Statistics();
  }





  this.init();

};

var dashboard = new Dashboard();






