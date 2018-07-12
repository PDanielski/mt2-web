<?php


namespace App\Controller\View;

use App\ItemShop\Category\Tree\CategoryNode;
use App\ItemShop\Category\Tree\CategoryTree;
use App\ItemShop\Category\Tree\CategoryTreeInterface;
use App\ItemShop\Discount\ProductDiscountGenerator;
use App\ItemShop\Discount\ProductDiscountProvider;
use App\ItemShop\Order\Order;
use App\ItemShop\Product\Attachment\AttachmentProvider;
use App\ItemShop\Product\Attachment\TypedAttachmentFactory;
use App\ItemShop\Product\Category;
use App\ItemShop\Product\Product;
use App\ItemShop\Category\Repository\CategoryRepositoryInterface;
use App\ItemShop\Product\Repository\DiscountedProductRepository;
use App\ItemShop\Product\Repository\ProductRepository;
use App\ItemShop\Product\Repository\ProductRepositoryInterface;
use App\ItemShop\Wallet\WalletProviderFactoryInterface;
use App\News\NewsProviderInterface;
use App\Player\Ranking\Exception\RankingNotRegisteredException;
use App\Player\Ranking\RankingProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends Controller {

    /**
     * @Route("/", name="homepage")
     * @param RankingProviderInterface $rankingProvider
     * @param NewsProviderInterface $newsProvider
     * @return Response
     */
    public function indexAction(RankingProviderInterface $rankingProvider, NewsProviderInterface $newsProvider) {
        try {
            $prestigePlayers = $rankingProvider->getRanking('prestige')->get(0, 10);
            $mmrPlayers = $rankingProvider->getRanking('mmr')->get(0, 10);
        } catch (RankingNotRegisteredException $ex) {
            throw new \RuntimeException($ex->getMessage(), 0, $ex);
        }

        $news = $newsProvider->get(10);
        return $this->render('pages/homepage.html.twig', [
            'prestigePlayers'=>$prestigePlayers,
            'mmrPlayers' => $mmrPlayers,
            'news' => $news
        ]);
    }

    /**
     * @Route("/test")
     * @param Metin2WalletProvider $walletProvider
     */
    public function test(CategoryTreeInterface $categoryTree) {
        $roots = $categoryTree->getRoots();

        $read = function(CategoryNode $node, int $depth = 0) use(&$read) {
            $string = $node->getCategory()->getId().'+'.$node->getCategory()->getName();
            $string = str_repeat('-', $depth).$string;
            echo $string."<br/>";
            foreach($node->getChildren() as $childNode) {
                $read($childNode, $depth+1);
            }
        };
        foreach($roots as $root) {
            $read($root);
            print_r("<br/><br/>");
        }
        exit;
    }

}