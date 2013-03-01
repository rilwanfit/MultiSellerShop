<?php

namespace MultiSellerShop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Album\Model\Album;
//use Album\Form\AlbumForm;

class CategoryController extends AbstractActionController {

    protected $albumTable;

    public function indexAction() {

        // if the user is not logged in, we don't need to show list.
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute('zfcuser');
        }
        
        $id = $this->params('id');
        
        $category = $this->getServiceLocator()->get('mss_category_service')->getCategoryForView($id);
        
        if (null === $category) {
            throw new \Exception('fore oh fore');
        }
        
        return new ViewModel(array(
                   'category' => $category
                ));
    }

    public function addAction() {

        // if the user is not logged in, we don't need to show list.
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute('account');
        }

        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $tempFile = null;

        $pre = $this->fileprg($form);
        var_Dump($pre);die();
        $request = $this->getRequest();

        

        if ($request->isPost()) {

            // Make certain to merge the files info!
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $album = new Album();

            $form->setInputFilter($album->getInputFilter());

            $form->setData($post);

            if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
                return $prg; // Return PRG redirect response
            } elseif (is_array($prg)) {
                if ($form->isValid()) {

                    $aData = $form->getData();

                    $aData['user_id'] = $this->zfcUserAuthentication()->getIdentity()->getId();

                    $album->exchangeArray($aData);

                    $this->getAlbumTable()->saveAlbum($album);

                    // Redirect to list of albums
                    return $this->redirect()->toRoute('album');
                } else {
                    // Form not valid, but file uploads might be valid...
                    // Get the temporary file information to show the user in the view
                    $fileErrors = $form->get('image-file')->getMessages();
                    if (empty($fileErrors)) {
                        $tempFile = $form->get('image-file')->getValue();
                    }
                }
            }
        }
        return new ViewModel(array(
                    'form' => $form,
                    'tempFile' => $tempFile,
                ));
    }

    public function editAction() {
        // if the user is not logged in, we don't need to show list.
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute('account');
        }

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array('action' => 'add'));
        }
        $album = $this->getAlbumTable()->getAlbum($id);
        $form = new AlbumForm();
        $form->bind($album);

        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($form->getData());
                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return new ViewModel(array(
                    'id' => $id,
                    'form' => $form,
                ));
    }

    public function deleteAction() {
        // if the user is not logged in, we don't need to show list.
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute('account');
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }
            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }
        return new ViewModel(array(
                    'id' => $id,
                    'album' => $this->getAlbumTable()->getAlbum($id)
                ));
    }

    public function getAlbumTable() {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();

            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

}
