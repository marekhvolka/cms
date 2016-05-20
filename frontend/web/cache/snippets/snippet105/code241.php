<script>
  function bezmez(TXT){
				var len=TXT.length;
				var OTXT="";
				for (var i=0; i<len; i++){
					c=TXT.substring(i,i+1);
					if (c!=" "){OTXT=OTXT+c}
				}
				return OTXT;
			}

			function test_num(CI){
				var ret="N"; //N-cislo0,C-cislo,E-chyba
				var vahy = new Array("1","2","4","8","5","10","9","7","3","6");
				var suma = 0;
				var len=CI.length;
				var j=0;
				for (var i=len-1; i>=0; i--){
					c=CI.charAt(i);
					if (c == 0){
					}else{
						if (c >= '1' && c <= '9'){
							ret="C";
							suma=suma+c*vahy[j];
						}else{
							ret="E";
							break;
						}
					}
					j++;
				}
				if ((suma % 11)==0){ret=ret+"M"}else{ret=ret+"E"};

				return ret;
			}

			function get_cur(){
				var ret='';
        var cur_begin;
        var bnk;

        bnk = document.mainform.bnk.value;
        cur_begin = document.mainform.cur.value;
        
        if(bnk == '8360'){
          cur_begin = '520700';
        }
        

        
				CU="000000"+bezmez(cur_begin);
				var len=CU.length;
				CU=CU.substring(len-6,len);

				document.getElementById("cur11").style.display="none";
				sts = test_num(CU);
				if (sts.substring(0,1)=="E"){ret='Predčíslie účtu nie je v numerickom tvare'}
				if (sts.substring(1,2)=='E'){ret='Chybné číslo účtu'; document.getElementById("cur11").style.display="block"}

				return ret;
			}

			function get_acc(){
				var ret='';
				AC="0000000000"+bezmez(document.mainform.acc.value);
				var len=AC.length;
				AC=AC.substring(len-10,len);

				document.getElementById("acc11").style.display="none";
				sts = test_num(AC);
				if (sts.substring(0,1)=="N"){ret='Nebolo zadané číslo účtu'}
				if (sts.substring(0,1)=="E"){ret='Číslo účtu nie je v numerickom tvare'}
				if (sts.substring(1,2)=='E'){ret='Chybné číslo účtu'; document.getElementById("acc11").style.display="block"}

				return ret;
			}

			function get_bnk(){
				var ret='';
				BK="0000"+bezmez(document.mainform.bnk.value);
				var len=BK.length;
				BK=BK.substring(len-4,len);

				document.mainform.bic.value=vrat_bic(BK);
				if (document.mainform.bic.value==''){ret='Chybný kód banky'}

				return ret;
			}

			function get_iban(){
				var ret='';
				IBV=document.mainform.iban.value;
				IB="";
				var len=IBV.length;
				if (len==0){ret='Zadajte číslo účtu vo formáte IBAN'}
				else {
					IB=bezmez(IBV);
					IB=IB.toUpperCase();
					if (IB.substring(0,2)!="SK"){ret='Chybný kód krajiny'}
					else {
						len=IB.length;
						if (len!=24){ret='Chybná dĺžka formátu IBAN'}
						else {
							for (var i=2; i<len; i++){
								c=IB.charAt(i);
								if (c >= '0' && c <= '9'){}
								else {
									ret='Kód nasledujúci za SK nie je numerický';
								}
							}
						}
					}
				}

				return ret;
			}

			function calc(buf) {
			 var index=0;
			 var dividend;
			 var pz=-1;
			 while(index <= buf.length) {
				if (pz < 0) {
				 dividend=buf.substring(index,index+9)
				 index+=9;
				} else if (pz >= 0 && pz <= 9) {
				 dividend=pz+buf.substring(index,index+8);
				 index+=8;
				} else {
				 dividend=pz+buf.substring(index,index+7);
				 index+=7;
				}
				pz=dividend % 97;
			 }
			 return pz;
			}

			function vrat_iban(){
				var stat='';
				IB='';
				$("#errormessage").hide();

				stat='';
				sts=get_cur();
				if (sts!=''){stat=sts; document.mainform.cur.focus();}

				sts=get_acc();
				if (sts!=''){stat=sts; document.mainform.acc.focus();}

				sts=get_bnk();
				if (sts!=''){stat=sts; document.mainform.bnk.focus();}

				if (stat==''){
							document.mainform.cur.value=CU;
							document.mainform.acc.value=AC;
							document.mainform.bnk.value=BK;

				DI=calc(BK+CU+AC+"282000");
							DI=98-DI;
							if (DI < 10) DI="0"+DI;

							IB="SK" + DI + BK + CU + AC;
							IB=IB.substring(0,4)+" "+IB.substring(4,8)+" "+IB.substring(8,12)+" "+IB.substring(12,16)+" "+IB.substring(16,20)+" "+IB.substring(20,24)
				}
				$('#iban').text(IB).show();
				if(stat){
					$("#errormessage").text(stat).show();
				}
				else{
					$("#errormessage").hide();
				}

			}

			function vrat_bic(BNK){
				var poc=40;
				bnkbic = new Array();
				bnkbic[0]  = "0200SUBASKBX";
				bnkbic[1]  = "0720NBSBSKBX";
				bnkbic[2]  = "0900GIBASKBX";
				bnkbic[3]  = "1030?";
				bnkbic[4]  = "1100TATRSKBX";
				bnkbic[5]  = "1111UNCRSKBX";
				bnkbic[6]  = "3000SLZBSKBA";
				bnkbic[7]  = "3100LUBASKBX";
				bnkbic[8]  = "5200OTPVSKBX";
				bnkbic[9]  = "5600KOMASK2X";
				bnkbic[10] = "5900PRVASKBA";
				bnkbic[11] = "6500POBNSKBA";
				bnkbic[12] = "7300INGBSKBX";
				bnkbic[13] = "7500CEKOSKBX";
				bnkbic[14] = "7930WUSTSKBA";
				bnkbic[15] = "8020CRLYSKBX";
				bnkbic[16] = "8050COBASKBX";
				bnkbic[17] = "8100KOMBSKBA";
				bnkbic[18] = "8120BSLOSK22";
				bnkbic[19] = "8130CITISKBA";
				bnkbic[20] = "8160EXSKSKBX";
				bnkbic[21] = "8170KBSPSKBX";
				bnkbic[22] = "8180SPSRSKBA";
				bnkbic[23] = "8191CSDSSKBA";
				bnkbic[24] = "8300HSBCSKBA";
				bnkbic[25] = "8320JTBPSKBA";
				bnkbic[26] = "8330FIOZSKBA";
				bnkbic[27] = "8340?";
				bnkbic[28] = "8350ABNASKBX";
				bnkbic[29] = "8360BREXSKBX";
				bnkbic[30] = "8370OBKLSKBA";
				bnkbic[31] = "8380?";
				bnkbic[32] = "8390?";
				bnkbic[33] = "8400?";
				bnkbic[34] = "8410RIDBSKBX";
				bnkbic[35] = "8420BFKKSKBB";
				bnkbic[36] = "8430KODBSKBX";
				bnkbic[37] = "9950FDXXSKBA";
				bnkbic[38] = "9951XBRASKB1";
				bnkbic[39] = "9952TPAYSKBX";

				BIC='';
				for (var i=0; i<poc; i++){
					if (BNK==bnkbic[i].substring(0,4))
						{BIC=bnkbic[i].substring(4,12);i=poc;}
				}

				return BIC;
			}

			function test_iban(){
				var stat='';
				IB='';
				$("#errormessage").hide();

				stat=get_iban();
				if (stat==''){

					DI=IB.substring(2,4);
					CU=IB.substring(8,14);
					AC=IB.substring(14,24);
					BK=IB.substring(4,8);
					KO=calc(BK+CU+AC+"2820"+DI);

					if(KO==1){
						document.mainform.cur.value=CU;
						document.mainform.acc.value=AC;
						document.mainform.bnk.value=BK;

						IB=IB.substring(0,4)+" "+IB.substring(4,8)+" "+IB.substring(8,12)+" "+IB.substring(12,16)+" "+IB.substring(16,20)+" "+IB.substring(20,24);
						$('#iban').text(IB).show();

						stat='';

						sts = test_num(CU);
						if (sts.substring(1,2)=='E'){
							stat='Chybný kód IBAN - číslo účtu';
							document.getElementById("cur11").style.display="block";
						}else{
							document.getElementById("cur11").style.display="none";
						}

						sts = test_num(AC);
						if (sts.substring(1,2)=='E'){
							stat='Chybný kód IBAN - číslo účtu';
							document.getElementById("acc11").style.display="block";
						}else{
							document.getElementById("acc11").style.display="none";
						}

						document.mainform.bic.value=vrat_bic(BK);
						if (document.mainform.bic.value==''){
							stat='Chybný kód IBAN - kód banky';
						}

						if (stat==''){
							document.getElementById("test").style.display="block";
						}else{
							document.getElementById("test").style.display="none";
						}

					}else{
						document.mainform.cur.value='';
						document.mainform.acc.value='';
						document.mainform.bnk.value='';
						document.mainform.bic.value='';
						document.getElementById("cur11").style.display="none";
						document.getElementById("acc11").style.display="none";
						stat='Chybný kód IBAN - kontrolné číslo';
						document.getElementById("test").style.display="none";
					}
				}
				else{
					document.mainform.iban.focus();
				}
				$("#errormessage").text(stat).show();
			}

			function vymaz_obr(){
				document.mainform.cur.value='';
				document.mainform.acc.value='';
				document.mainform.bnk.value='';
				document.mainform.bic.value='';
				$('#iban').text('');
				document.mainform.cur.focus();
				$("#errormessage").hide();
				document.getElementById("cur11").style.display="none";
				document.getElementById("acc11").style.display="none";
				//document.getElementById("test").style.display="none";
			}
</script>