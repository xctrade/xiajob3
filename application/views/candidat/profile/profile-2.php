<?php // mes compétences ?>

<?php echo form_open('main/edit_profile/2','class="form"'); ?>

<?php
$description = array(
    'name' => 'description',
    'id'    => 'description',
    'value' => set_value('description',$user->description),
    'placeholder' => 'exemple : Passionné de décoration florale moderne, je pratique avec un style très naturel autour de couleur blanche et verte.',
    'rows' => '4',
    'cols' => '140',
    'class' => 'span10',
);


$informatique = array(
    'name' => 'informatique',
    'id'    => 'informatique',
    'value' => set_value('informatique',$user->resume->computer_skill),
    'placeholder' => 'Autre logiciel / compétence : précisez',
    'class' => 'input-xlarge',
    'maxlength' => 150,
    'size'  => 150,
);


?>


<p class='lead'>Description rapide</p>

<div class='well'>
    <p>Décrivez en 2 lignes votre style de pratique, votre passion.</p>
    <?php echo form_textarea($description); ?>
</div>



<p class='lead'>Mes compétences</p>


<div class='well'>
    
    <table class='table'>
        <thead>
            <tr>
                <th colspan="2"></th>
                <th>Aucune</th>
                <th>Débutant</th>
                <th>Intermédiaire</th>
                <th>Confirmé</th>
                <th>Expert</th>
            </tr>
        </thead>
        
        <tbody>
            
            <?php
            foreach($comp_list as $key => $competence) {
                
                echo("<tr>
                <td><img src='".base_url().'public/img/skills/'.$competence->picto."' /></td>
                <th>".$competence->nom."</th>");
                
                
                for ($i=1; $i < 6; $i++) {
                    
                    echo("<td>");
                    
                    if(!isset($user->resume->skills[$competence->id])) :
                        $user->resume->skills[$competence->id] = new stdClass();
                        $user->resume->skills[$competence->id]->score = 1;
                    endif;
                    
                    echo form_radio($competence->id, $i, test_comp($user->resume->skills[$competence->id]->score, $i)); 
                    echo("</td>");
                    
                } 
                echo("</tr>");   
            }                       
            ?>            
        </tbody>                        
    </table>
</div>

<p class="lead">Divers</p>

<div id='styles' class='well'>
    <div class='row-fluid'> 
              
        <div class='span12'><strong>Styles pratiqués</strong> (plusieurs choix possibles)</div>
        
        <label class="checkbox inline span3">                       
          <?php echo form_checkbox('libreservice', 1, test_option($user, 'libreservice')); ?> Libre service
        </label>
        
        <label class="checkbox inline span3">
          <?php echo form_checkbox('even', 1, test_option($user, 'even')); ?> Evénementiel
        </label>
        
        <label class="checkbox inline span3">            
          <?php echo form_checkbox('design', 1, test_option($user, 'design')); ?> Designer Floral
        </label>
        
        <label class="checkbox inline span2">            
          <?php echo form_checkbox('tradi', 1, test_option($user, 'tradi')); ?> Traditionnel
        </label>
            
    </div>
</div>

<div id='permis' class='well'>
    <div class='row-fluid'> 
              
        <div class='span12'><strong>Permis de conduire</strong></div>
        
        <label class="checkbox inline span3">
          <?php echo form_checkbox('pieton', 1, test_option($user, 'pieton')); ?> Pas de permis
        </label>
        
        <label class="checkbox inline span3">
          <?php echo form_checkbox('permisb', 1, test_option($user, 'permisb')); ?> Permis B
        </label>
        
        <label class="checkbox inline span3">
          <?php echo form_checkbox('permisc', 1, test_option($user, 'permisc')); ?> Permis C
        </label>
            
    </div>
</div>

<div id='informatique' class='well'>
    <div class='row-fluid'> 
              
        <div class='span12'><strong>Informatique</strong></div>
        
        <label class="checkbox inline span3">
          <?php echo form_checkbox('word', 1, test_option($user, 'word')); ?> Word
        </label>
        
        <label class="checkbox inline span3">
          <?php echo form_checkbox('excel', 1, test_option($user, 'excel')); ?> Excel
        </label>
        
        <div class='span4'>
            Autre : 
            <?php echo form_input($informatique); ?>
        </div>
            
    </div>
</div>



<?php echo form_submit("submit","Enregistrer mes compétences", "class='btn btn-pink pull-right'");?>
<?php echo form_close(); ?>


