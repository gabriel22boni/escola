<?php
use App\Http\Middleware\CEOUser;
use App\Http\Middleware\MAdminUser;
use App\Http\Middleware\AdminUser;
use App\Http\Middleware\CobradorUser;

    Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'painel'],       function (){
        
        
        Route::post ('/cadastro/search/state'   , 'cadastrosController@searchState'         )->name('search.state');
        
        Route::group(['middleware'=>CEOUser::Class], function(){
            Route::post ('/cadastro/ceo/update' , 'cadastrosController@ceoUpdate'       )->name('ceo.update');
            Route::post ('/cadastro/ceo/delete' , 'cadastrosController@ceoDelete'       )->name('ceo.delete');
            Route::post ('/cadastro/ceo/dados' , 'cadastrosController@ceoDados'       )->name('cadastros.ceo.dados');
            Route::post ('/cadastro/ceo/insert' , 'cadastrosController@ceoInsert'       )->name('cadastros.ceo.insert');
            Route::get ('/cadastro/ceo/search' , 'cadastrosController@ceoSearch'       )->name('cadastros.ceo.search');
            Route::post ('/cadastro/ceo/search' , 'cadastrosController@ceoSearch'       )->name('cadastros.ceo.search');
            Route::get  ('/cadastro/ceo'            , 'cadastrosController@ceoView'             )->name('cadastros.ceo');
        });
        
        Route::group(['middleware'=>CEOUser::Class], function(){
            Route::post ('/cadastro/escola/update' , 'cadastrosController@masterAdminUpdate'       )->name('masterAdmin.update');
            Route::post ('/cadastro/escola/delete' , 'cadastrosController@masterAdminDelete'       )->name('masterAdmin.delete');
            Route::post ('/cadastro/escola/dados' , 'cadastrosController@masterAdminDados'       )->name('cadastros.masterAdmin.dados');
            Route::post ('/cadastro/escola/insert' , 'cadastrosController@masterAdminInsert'       )->name('cadastros.masterAdmin.insert');
            Route::get ('/cadastro/escola/search' , 'cadastrosController@masterAdminSearch'       )->name('cadastros.masterAdmin.search');
            Route::post ('/cadastro/escola/search' , 'cadastrosController@masterAdminSearch'       )->name('cadastros.masterAdmin.search');
            Route::get  ('/cadastro/escola'    , 'cadastrosController@masteradminView'     )->name('cadastros.masterAdmin');
        });

        Route::group(['middleware'=>MAdminUser::Class], function(){
            Route::post ('/cadastro/professor/update' , 'cadastrosController@adminUpdate'       )->name('admin.update');
            Route::post ('/cadastro/professor/delete' , 'cadastrosController@adminDelete'       )->name('admin.delete');
            Route::post ('/cadastro/professor/dados' , 'cadastrosController@adminDados'       )->name('cadastros.admin.dados');
            Route::post ('/cadastro/professor/insert' , 'cadastrosController@adminInsert'       )->name('cadastros.admin.insert');
            Route::get ('/cadastro/professor/search' , 'cadastrosController@adminSearch'       )->name('cadastros.admin.search');
            Route::post ('/cadastro/professor/search' , 'cadastrosController@adminSearch'       )->name('cadastros.admin.search');
            Route::get  ('/cadastro/professor'          , 'cadastrosController@adminView'           )->name('cadastros.admin');
            
            Route::post  ('/cadastro/pesquisa/quest/update' , 'pesquisaController@questUpdate'           )->name('cadastros.pesquisa.quest.update');
            Route::post  ('/cadastro/pesquisa/quest/del' , 'pesquisaController@QuestDel'           )->name('cadastros.pesquisa.quest.del');
            Route::post  ('/cadastro/pesquisa/quest/get' , 'pesquisaController@QuestGet'           )->name('cadastros.pesquisa.quest.get');
            Route::post ('/cadastro/pesquisa/getquests' , 'pesquisaController@pesquisagetQuests'       )->name('pesquisa.getQuests');
            Route::post ('/cadastro/pesquisa/addquest' , 'pesquisaController@pesquisaAddQuest'       )->name('pesquisa.addQuest');
        
            Route::post ('/cadastro/pesquisa/porcentagem' , 'pesquisaController@porcentagem'       )->name('pesquisa.porcentagem');
            Route::post ('/cadastro/pesquisa/update' , 'pesquisaController@pesquisaUpdate'       )->name('pesquisa.update');
            Route::post ('/cadastro/pesquisa/delete' , 'pesquisaController@pesquisaDelete'       )->name('pesquisa.delete');
            Route::post ('/cadastro/pesquisa/dados' , 'pesquisaController@pesquisaDados'       )->name('cadastros.pesquisa.dados');
            Route::post ('/cadastro/pesquisa/insert' , 'pesquisaController@pesquisaInsert'       )->name('cadastros.pesquisa.insert');
            Route::get  ('/cadastro/pesquisa/search' , 'pesquisaController@pesquisaSearch'       )->name('cadastros.pesquisa.search');
            Route::post ('/cadastro/pesquisa/search' , 'pesquisaController@pesquisaSearch'       )->name('cadastros.pesquisa.search');
            Route::get  ('/cadastro/pesquisa'          , 'pesquisaController@pesquisaView'           )->name('cadastros.pesquisa');

            Route::post ('/cadastro/materia/update' , 'cadastrosController@materiaUpdate'       )->name('materia.update');
            Route::post ('/cadastro/materia/delete' , 'cadastrosController@materiaDelete'       )->name('materia.delete');
            Route::post ('/cadastro/materia/dados' , 'cadastrosController@materiaDados'       )->name('cadastros.materia.dados');
            Route::post ('/cadastro/materia/insert' , 'cadastrosController@materiaInsert'       )->name('cadastros.materia.insert');
            Route::get  ('/cadastro/materia/search' , 'cadastrosController@materiaSearch'       )->name('cadastros.materia.search');
            Route::post ('/cadastro/materia/search' , 'cadastrosController@materiaSearch'       )->name('cadastros.materia.search');
            Route::get  ('/cadastro/materia'          , 'cadastrosController@materiaView'           )->name('cadastros.materia');
        });

        Route::group(['middleware'=>AdminUser::Class], function(){
            Route::post ('/cadastro/aluno/update' , 'cadastrosController@cobradorUpdate'       )->name('cobrador.update');
            Route::post ('/cadastro/aluno/delete' , 'cadastrosController@cobradorDelete'       )->name('cobrador.delete');
            Route::post ('/cadastro/aluno/dados' , 'cadastrosController@cobradorDados'       )->name('cadastros.cobrador.dados');
            Route::post ('/cadastro/aluno/insert' , 'cadastrosController@cobradorInsert'       )->name('cadastros.cobrador.insert');
            Route::get ('/cadastro/aluno/search' , 'cadastrosController@cobradorSearch'       )->name('cadastros.cobrador.search');
            Route::post ('/cadastro/aluno/search' , 'cadastrosController@cobradorSearch'       )->name('cadastros.cobrador.search');
            Route::get  ('/cadastro/aluno'       , 'cadastrosController@cobradorView'        )->name('cadastros.cobrador');
            
            Route::post ('/cadastro/produtos/upload' , 'uploadController@produtoUpload'       )->name('produto.upload');
            Route::post ('/cadastro/produtos/update' , 'cadastrosController@produtoUpdate'       )->name('produto.update');
            Route::post ('/cadastro/produtos/delete' , 'cadastrosController@produtosDelete'       )->name('produto.delete');
            Route::post ('/cadastro/produtos/dados' , 'cadastrosController@produtosDados'       )->name('cadastros.produto.dados');
            Route::post ('/cadastro/produtos/insert' , 'cadastrosController@produtosInsert'       )->name('cadastros.produto.insert');
            Route::get ('/cadastro/produtos/search' , 'cadastrosController@produtosSearch'       )->name('cadastros.produto.search');
            Route::post ('/cadastro/produtos/search' , 'cadastrosController@produtosSearch'       )->name('cadastros.produto.search');
            Route::get ('/cadastro/produtos' , 'cadastrosController@produtosView'       )->name('cadastros.produto');
        });

        Route::post ('/perfil/update'           , 'UserController@profileUpdate'            )->name('perfil.update');
        Route::get  ('/perfil'                  , 'UserController@profile'                  )->name('perfil');
        
        Route::post  ('/dashboard/authenticateUsr', 'painelController@authenticateUsr'       )->name('painel.authenticateUsr');
        
        Route::get  ('/dashboard'               , 'painelController@index'                  )->name('painel.home');
    });

    Route::group(['middleware' => ['auth'], 'namespace' => 'Admin'],       function (){
        Route::get('/'                              , 'painelController@index'               )->name('home');
    });

    Route::post('/pesquisa/qtd','Admin\pesquisaController@qtde')->name('pesquisa.qtd');
    Route::post('/pesquisa/dados','Admin\pesquisaController@dados')->name('pesquisa.dados');
    Route::get('/pesquisa/{nomePesq}','Admin\pesquisaController@index')->name('pesquisa');
    Auth::routes();
