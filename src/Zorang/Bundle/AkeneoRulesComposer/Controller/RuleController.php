<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Controller;
use Symfony\Component\Form\FormError;
use Zorang\Bundle\AkeneoRulesComposer\Entity\Rule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zorang\Bundle\AkeneoRulesComposer\Utility\CreateYmlFile;
use Zorang\Bundle\AkeneoRulesComposer\Utility\CreateRuleValidate;
use Akeneo\Bundle\RuleEngineBundle\Model\RuleDefinion;
use Symfony\Component\HttpFoundation\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Yaml\Parser;
class RuleController extends Controller
{

    public $logger;
    public function indexAction()
    {
        $this->logger =$this->getLogger();
        $this->logger->addInfo("Index Action");
        return $this->render('ZorangAkeneoRulesComposer:Rule:index.html.twig', array('name' => ''));
    }

    public function createAction(Request $request)
    {
        $this->logger =$this->getLogger();
        $this->logger->addInfo(' Rule Create Action');
        return $this->editAction($request);

    }

    public function editAction(Request $request)
    {

        $this->logger =$this->getLogger();
        $this->logger->Info('Edit Rule Action Starts');


        $rule = new Rule();

        $attributes = array();

        $attributes = $request->attributes->get('_route_params');

        if (count($attributes) > 0) {
            $rule->setId($attributes['id']);
        }

        $ruleForm = $this->createForm(
            'zorang_rule',
            $rule,
            array(
                'action' => $this->generateUrl('pimee_catalog_rule_rule_create'),
                'method' => 'POST',
            ));

        $ruleForm->handleRequest($request);


        if ($request->isMethod('POST')) {
            if ($ruleForm->isSubmitted()) {
                try {

                    $rule_config = file_get_contents(__DIR__ . '/../Resources/config/config_rule.yml');
                    $yamlParse = new Parser();
                    $app_path = $this->container->getParameter('kernel.root_dir');
                    $config_value = $yamlParse->parse($rule_config);
                    $dir = $config_value["parameters"]["rule_file_path"];
                    $rulesCopyTo = $dir . "/" . $config_value["parameters"]["rule_file"];
                    $log_path = $app_path . "/logs/" . $config_value["parameters"]["logfile"];
                    $console_path = $config_value["parameters"]["php_bin"] . " " . $app_path . "/console";
                    if (!file_exists($dir) && !is_dir($dir)) {
                        // $oldmask = umask(0);
                        mkdir($dir, 0777);
                        $this->logger->addInfo("Directory Created :" . $dir);
                    }
                    $this->logger->addInfo("Rule Config Details : " . $dir . " : " . $log_path . " : " . $console_path . " : " . $rulesCopyTo);
                    $this->logger->addInfo("Config Validation : " . file_exists($dir) . ":" . is_dir($dir) . ":" . file_exists($config_value["parameters"]["logfile"]) . ":" . ":" . file_exists($app_path) . ":" . is_dir($app_path));
                    if ($this->dirValidation($dir, $app_path)) {


                        $data = $request->getContent();
                        $arraydata = urldecode($data);
                        $this->logger->addInfo("Data submitted to create rule :" . $arraydata);
                        $ruleErr = CreateRuleValidate::validate($arraydata);
                        if (!empty($ruleErr)) {
                           // $this->addFlash('notice', $ruleErr);//$ruleForm->addError("Please give actions");
                            $ruleForm->addError(new FormError($ruleErr));
                            return $this->render('ZorangAkeneoRulesComposer:Rule:create.html.twig', [
                                'form' => $ruleForm->createView()
                            ]);
                        }else{
                        $filename = CreateYmlFile::createYml($arraydata, $dir);
                        //echo $hello;
                        if (file_exists($filename)) {
                            $this->logger->addInfo("Rule file :" . $filename);
                            copy($filename, $rulesCopyTo);
                            $this->logger->addInfo("Rule file Copied to :" . $rulesCopyTo);
                            //  $pid = exec($pim_Console_path . " akeneo:batch:job rules_import --env=prod >" . $log_path);
                            //$pathArra= json_encode(array("\filePath\"=> "//tmp//addrule_1496874063.yml"));
                            $cmd = $console_path . " akeneo:batch:job rules_import -c " . "{\\\"filePath\\\":\\\"" . $rulesCopyTo . "\\\"}" . " --env=prod >> " . $log_path;
                            $this->logger->addInfo("Rule Command :" . $cmd);
                            //   file_put_contents('/tmp/rulecmd.txt',$cmd, FILE_APPEND | LOCK_EX);
                            exec($cmd, $return_var);
                            if (file_exists($log_path)) {
                                $statusError = exec("tail -10 " . $log_path . " | grep 'batch.ERROR'");
                                $statusWarn = exec("tail -10 " . $log_path . " | grep 'batch.WARNING'");
                                $status = exec("tail -10 " . $log_path . " | grep 'Import rules_import has been successfully executed'");
                                if (!empty($statusError) && strrpos($statusError, "batch.ERROR") !== false) {
                                    $statusmsg = exec("tail -5 " . $log_path . " | grep 'error occurred'");

                                    $this->addFlash('notice', $statusmsg);
                                } else if (!empty($statusWarn) && strrpos($statusWarn, "batch.WARNING") !== false) {

                                    $statusmsg = exec("tail -5 " . $log_path . " | grep 'warnings'");
                                    if(strrpos($statusWarn,"REASON")!==false){
                                        $statusmsg = exec("tail -5 " . $log_path . " | grep 'REASON'");
                                        $pos = stripos($statusmsg, "REASON:", 1);
                                       // $end = stripos($statusmsg, "Pim", 1);
                                        $statusmsg=substr($statusmsg,$pos,strlen($statusmsg));
                                        $ruleForm->addError(new FormError($statusmsg));
                                        return $this->render('ZorangAkeneoRulesComposer:Rule:create.html.twig', [
                                            'form' => $ruleForm->createView()
                                        ]);
                                    }else{
                                        $this->addFlash('notice', $statusmsg);
                                    }

                                } else if (!empty($status) && strrpos($status, "Import rules_import has been successfully executed") !== false) {
                                    $this->addFlash('notice', 'The rule has been successfully saved.');
                                } else {
                                    $this->addFlash('notice', 'Rule execution failed');
                                    $this->logger->addError("Rule execution failed" . exec("tail -10 " . $log_path));
                                }
                            } else {
                                $this->addFlash('notice', "Internal command execution failed ");
                            }
                        } else {
                            $this->logger->addError("Rulefile not available to execute");
                        }
                    }
                    } else {
                        $this->logger->addError("Please verify the values defined in config_rule.yml");
                    }

                }
                catch (Exception $e) {
                    $this->addFlash('notice', $e->getMessage());
                    $this->logger->addError($e->getMessage());
                }


            }

            return $this->redirect($this->generateUrl('pimee_catalog_rule_rule_index'));
        }
        //form_errors

        return $this->render('ZorangAkeneoRulesComposer:Rule:create.html.twig', [
            'form' =>$ruleForm->createView()
        ]);


    }
    public  function getLogger()
    {
        $log = new Logger('rulesengine');
        $dir=$this->get('kernel')->getRootDir();
        $log->pushHandler(new StreamHandler($dir.'/logs/rulesengine.log', Logger::DEBUG));

        return $log;


    }
    public  function dirValidation($dir,$app_path)
    {
        if(file_exists($dir) && is_dir($dir) && file_exists($app_path) && is_dir($app_path) ) {
            return true;
        }else{
            return false;
        }


    }


}