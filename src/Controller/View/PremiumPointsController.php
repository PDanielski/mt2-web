<?php


namespace App\Controller\View;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Account\Repository\AccountRepositoryInterface;
use App\PremiumPoints\PremiumPointsPackageRepositoryInterface;
use App\PremiumPoints\MoneygrabberRepositoryInterface;
use App\PremiumPoints\PaypalTransactionRepositoryInterface;
use App\PremiumPoints\PaypalTransaction;
use Psr\Log\LoggerInterface;

class PremiumPointsController extends Controller {

    /**
     * @Route("/premium-points", name="premiumpoints")
     * @return Response
     */
    public function indexAction(PremiumPointsPackageRepositoryInterface $packagesRepository, MoneygrabberRepositoryInterface $moneygrabberRepository) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $packages = $packagesRepository->getAll();
        $moneygrabber = $moneygrabberRepository->getPoorest();
        return $this->render('pages/premium-points/premiumpoints.html.twig', [
            'packages'=>$packages,
            'moneygrabber'=>$moneygrabber
        ]);
    }

    /**
     * @Route("/premium-points/paypal-ipn", name="premiumpoint")
     * @return Response
     */
    public function paypalIpnAction(
        PremiumPointsPackageRepositoryInterface $packagesRepository,
        MoneygrabberRepositoryInterface $moneygrabberRepository,
        AccountRepositoryInterface $accountRepository,
        PaypalTransactionRepositoryInterface $paypalTransactionRepository,
	LoggerInterface $logger
        ) {
        try {
            $raw_post_data = file_get_contents('php://input');
	        $logger->info("Transazione paypal: ". $raw_post_data);

            $raw_post_array = explode('&', $raw_post_data);
            $myPost = array();
            foreach ($raw_post_array as $keyval) {
                $keyval = explode ('=', $keyval);
                if (count($keyval) == 2)
                    $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
		    $logger->info("data parsato");
            $req = 'cmd=_notify-validate';
            if(function_exists('get_magic_quotes_gpc')) {
                $get_magic_quotes_exists = true;
            }
            foreach ($myPost as $key => $value) {
                if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                    $value = urlencode(stripslashes($value));
                } else {
                    $value = urlencode($value);
                }
                $req .= "&$key=$value";
            }

            $ch = curl_init($this->container->getParameter('paypal_link'));
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
            $res = curl_exec($ch);

            if( !$res) {
                curl_close($ch);
                exit;
            }

            curl_close($ch);
	        $logger->info("Transazione paypal, controllo: ". $res);
            if (strcmp ($res, "VERIFIED") == 0) {

                $transaction = new PaypalTransaction();
                foreach($myPost as $field => $value){
                    if(property_exists($transaction,$field)){
                        $transaction->$field = $value;
                    }
                }
                $txn_id=$myPost['txn_id'];
                $custom = $myPost['custom'];

                $custom = explode(',',$custom);
                $accountUsername = $custom[0];
                $receiverId = $custom[1];
                $packageId = $custom[2];

                $currency='EUR';
                $receiverEmail=$myPost['receiver_email'];
                $paymentAmount=$myPost['mc_gross'];
                $payerEmail=$myPost['payer_email'];

                $moneyGrabber = $moneygrabberRepository->getByEmail($receiverEmail);
                $package = $packagesRepository->getById($packageId);
                $user = $accountRepository->getByLogin($accountUsername);
                if(($paymentAmount != $package->getCost()/100.0)
                    || !$moneyGrabber
                    || !$user
                ){
                    $transaction->status = "REFUSED";
                    $paypalTransactionRepository->insertTransaction($transaction);
                    return new Response(1);
                }

                $user->changePremiumpoints($package->getPoints());
		        $paymentAmountInCents=  (int)(((float)$paymentAmount)*100);
                $moneygrabberRepository->addEarnings($moneyGrabber->getEmail(), $paymentAmountInCents);
                $transaction->status = "OK";
                $paypalTransactionRepository->insertTransaction($transaction);


                return new Response(1);

            } else if (strcmp ($res, "INVALID") == 0) {
                return new Response(0);
            }
        } catch (\Throwable $e) {
            $logger->info($e);
            return new Response(0);
        }
    }

     /** @Route("/premium-points/paypal-link/{packageId}", name="premiumpoints-paypal-link") */
    public function getPaypalActionLinkFromPackageId($packageId, MoneygrabberRepositoryInterface $moneygrabberRepository, PremiumPointsPackageRepositoryInterface $packagesRepository){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $user = $this->getUser();
        $package = $packagesRepository->getById($packageId);
        if($package){
            $url = $this->container->getParameter('paypal_link');
            $poorest = $moneygrabberRepository->getPoorest();
            $custom = $this->getUser()->getUsername().','.$poorest->getId().','.$package->getId();
            $data = array(
                'cmd' => '_donations',
                'item_name' => $package->getPoints() . ' Premiumpoints',
                'business' => $poorest->getEmail(),
                'notify_url' => 'https://metin2warlords.net/premium-points/paypal-ipn',
                'rm' => 2,
                'amount' => $package->getCost()/100,
                'custom' => $custom,
                'currency_code' => 'EUR',
                'country' => 'IT'
            );
            $url.='?'.http_build_query($data);
            return $this->redirect($url);
            return new JsonResponse(urldecode($url));
        }
        return new JsonResponse("package not found");
    }
}