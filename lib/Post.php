<?php
    class Post{
    	
		var $id;
		var $tabla;
		var $titulo;
		var $fecha;
		var $contenido;
		var $ancho;
		var $tbox;
		var $showAddWhenAdmin;
		var $showEditWhenAdmin;
		var $showDelWhenAdmin;
		
		public function Post($pTitulo="Titulo", $pContenido="Contenido", $pAncho=550, $pShowAddWhenAdmin=false, $pShowEditWhenAdmin=false, $pShowDelWhenAdmin=false){
			$this->id = $pId;
			$this->titulo = $pTitulo;
			$this->contenido = $pContenido;
			$this->ancho = $pAncho;
			$this->tbox = new ToolBox();
		 	$this->showAddWhenAdmin = $pShowAddWhenAdmin;			
		 	$this->showEditWhenAdmin = $pShowEditWhenAdmin;
			$this->showDelWhenAdmin = $pShowDelWhenAdmin;
		}
		
		public function ToString(){

				$myUser = new cusuario();
				$myUser->GetPorId($_SESSION["CurrentUser"]);
				if($myUser->privilegio == "admin"){
					if($this->showAddWhenAdmin)
						$this->tbox->btnAdd->enabled = true;
					if($this->showEditWhenAdmin)
						$this->tbox->btnEdit->enabled = true;
					if($this->showDelWhenAdmin)
						$this->tbox->btnDel->enabled = true;
				}
				
				$this->tbox->btnEdit->onClick = "EditPost('$this->id')";
				$this->tbox->btnAdd->id = "add-$this->id";
				$this->tbox->btnAdd->onClick = "AddPost('$this->id', '$this->tabla')";
				$this->tbox->btnEdit->id = "edit-$this->id";
				$this->tbox->btnDel->id = "del-$this->id";
				$this->tbox->btnDel->onClick = "DelPost('$this->id')";
				$this->tbox->btnSave->id = "sav-$this->id";
				$this->tbox->btnSave->onClick = "SavePost('$this->id')";
				$this->tbox->btnCancel->id = "can-$this->id";
				$this->tbox->btnCancel->onClick = "CancelPost('$this->id')";
				$fechaField = "";
				if($this->fecha != ""){
					$fechaField = "<input type='text' id='fch-$this->id' class='PostDate' value='$this->fecha' disabled='true' />";
				}

			return "
			<div id='pst-$this->id' class='Post' style='width: " . $this->ancho . "px;' >
	    		<div class='PostTitle' style='width: " . ($this->ancho - 12) . "px;'>
					" . $this->tbox->ToString() . $fechaField .
					"<input type='text' id='txt-$this->id' class='innerTitle' value='$this->titulo' disabled='true' />
				</div>
				<div id='cont-$this->id' class='PostContent'>
				    <div id='area-$this->id' class='innerContent'>
						$this->contenido
					</div>					
				</div>
				<input type='hidden' id='tmpcnt-$this->id' value=''/>
				<input type='hidden' id='tmptit-$this->id' value=''/>
				<input type='hidden' id='tmpfch-$this->id' value=''/>
				<input type='hidden' id='id-$this->id' value='$this->id'/>
				<input type='hidden' id='tbl-$this->id' value='$this->tabla'/>
   			</div>
			
			";
		}
		
		public function Show(){
			echo($this->ToString());
		}
    }
	


	class InnerPost extends Post{
		
		public function ToString(){
			
			$myUser = new cusuario();
			$myUser->GetPorId($_SESSION["CurrentUser"]);
			if($myUser->privilegio == "admin"){
				if($this->showAddWhenAdmin)
					$this->tbox->btnAdd->enabled = true;
				if($this->showEditWhenAdmin)
					$this->tbox->btnEdit->enabled = true;
				if($this->showDelWhenAdmin)
					$this->tbox->btnDel->enabled = true;
			}						
			
				$this->tbox->btnEdit->onClick = "EditPost('$this->id')";
				$this->tbox->btnAdd->id = "add-$this->id";
				$this->tbox->btnAdd->onClick = "AddPost('$this->id', '$this->tabla')";
				$this->tbox->btnEdit->id = "edit-$this->id";
				$this->tbox->btnDel->id = "del-$this->id";
				$this->tbox->btnDel->onClick = "DelPost('$this->id')";		
				$this->tbox->btnSave->id = "sav-$this->id";
				$this->tbox->btnSave->onClick = "SavePost('$this->id')";
				$this->tbox->btnCancel->id = "can-$this->id";
				$this->tbox->btnCancel->onClick = "CancelPost('$this->id')";
				$fechaField = "";
				if($this->fecha != ""){
					$fechaField = "<input type='text' id='fch-$this->id' class='PostDate' value='$this->fecha' disabled='true' />";
				}
			
			return "
			<div id='pst-$this->id' class='innerPost' style='width: " . $this->ancho . "px;'>
    		<div class='PostTitle' style='width: " . ($this->ancho - 4) . "px;'>
				"  . $this->tbox->ToString() . $fechaField .
				"<input type='text' id='txt-$this->id' class='innerTitle' value='$this->titulo' disabled='true' />
			</div>
			<div id='cont-$this->id' class='PostContent'>
			    <div id='area-$this->id' class='innerContent'>
					$this->contenido
				</div>
				<input type='hidden' id='tmpcnt-$this->id' value=''/>
				<input type='hidden' id='tmptit-$this->id' value=''/>
				<input type='hidden' id='tmpfch-$this->id' value=''/>
				<input type='hidden' id='id-$this->id' value='$this->id'/>
				<input type='hidden' id='tbl-$this->id' value='$this->tabla'/>
			</div>
   		</div>
			
			";
		}
		
	}
	
	class InnerInnerPost extends InnerPost{
		
		public function ToString(){
			
			$myUser = new cusuario();
			$myUser->GetPorId($_SESSION["CurrentUser"]);
			if($myUser->privilegio == "admin"){
				if($this->showAddWhenAdmin)
					$this->tbox->btnAdd->enabled = true;
				if($this->showEditWhenAdmin)
					$this->tbox->btnEdit->enabled = true;
				if($this->showDelWhenAdmin)
					$this->tbox->btnDel->enabled = true;
			}
			
				$this->tbox->btnEdit->onClick = "EditPost('$this->id')";
				$this->tbox->btnAdd->id = "add-$this->id";
				$this->tbox->btnEdit->id = "edit-$this->id";
				$this->tbox->btnDel->id = "del-$this->id";
				$this->tbox->btnDel->onClick = "DelPost('$this->id')";		
				$this->tbox->btnSave->id = "sav-$this->id";
				$this->tbox->btnSave->onClick = "SavePost('$this->id')";
				$this->tbox->btnCancel->id = "can-$this->id";
				$this->tbox->btnCancel->onClick = "CancelPost('$this->id')";
				$fechaField = "";
				if($this->fecha != ""){
					$fechaField = "<input type='text' id='fch-$this->id' class='PostDate' value='$this->fecha' disabled='true' />";
				}
			
			return "
			<div id='pst-$this->id' class='innerInnerPost' style='width: " . $this->ancho . "px;'>
    		<div class='PostTitle' style='width: " . ($this->ancho - 4) . "px;'>
				" . $this->tbox->ToString() . $fechaField .
				"<input type='text' id='txt-$this->id' class='innerTitle' value='$this->titulo' disabled='true' />
			</div>
			<div id='cont-$this->id' class='PostContent'>
			    <div id='area-$this->id' class='innerContent'>
					$this->contenido
				</div>
				<input type='hidden' id='tmpcnt-$this->id' value=''/>
				<input type='hidden' id='tmptit-$this->id' value=''/>
				<input type='hidden' id='tmpfch-$this->id' value=''/>
				<input type='hidden' id='id-$this->id' value='$this->id'/>
				<input type='hidden' id='tbl-$this->id' value='$this->tabla'/>
			</div>
   		</div>
			
			";
		}
	}
?>
