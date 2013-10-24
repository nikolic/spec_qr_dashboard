var Dashboard = function(){
  var self = this;

  this.loadedPartsCount = 0;

  this.init = function(){

    this.LoadPart(CREATE_QR_PATH, $("#code_generator"));
    this.LoadPart(STATISTICS_PATH, $("#statistics_and_reports"), self.onLoadedStatistics);

    $(document).on("click", "#create_qr", function(){
      var formData = { weight: parseInt($("#weight").val()),
                       quantity: parseInt($("#quantity").val())};
      console.log(formData);

      self.generateQRcode(formData);

    });

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

  this.generateQRcode = function(formData){
      $.ajax({
        type: "POST",
        url: GENERATE_PATH,
        data: JSON.stringify(formData),
        contentType: "application/json; charset=utf-8",
        dataType: "text",
        success: function(html){
          //console.log(data);
          $("#preview_qr").html(html);
        },
        error : function(err){
          console.log(err);
        }
      });
  }

  this.init();

};

var dashboard = new Dashboard();






