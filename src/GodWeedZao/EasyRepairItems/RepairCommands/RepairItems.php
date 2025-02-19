<?php

namespace GodWeedZao\EasyRepairItems\RepairCommands;

use GodWeedZao\EasyRepairItems\Main;
use GodWeedZao\EasyRepairItems\RepairCommands\RepairCommand;
use pocketmine\player\Player;
use pocketmine\Server;

class RepairItems
{

    private $plugin;

    /**
     * RepairItems constructor.
     * @param Main $plugin
     */

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param Player $player
     */

    public function RepairItem(Player $player)
    {
        if (Main::Config("MONEY") === true) {
            $EconomyAPI = Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
            $money = $EconomyAPI->myMoney($player);
            $price = Main::Config("Repair-Item-Price-Money");
            $enchantedPrice = Main::Config("Repair-Enchanted-Item-Price-Money");
            $slot = $player->getInventory()->getHeldItemIndex();
            $Item = $player->getInventory()->getItem($slot);
            if ($Item->getDamage() > 0) {
                if (!$player->hasPermission("EasyRepairItems.command")) {
                    if (count($Item->getEnchantments()) !== 0) {
                        if ($money >= $enchantedPrice) {
                            $EconomyAPI->reduceMoney($player, $price);
                            $player->getInventory()->setItem($slot, $Item->setDamage(0));
                            if (Main::Config("Send-Title-Success") === true) {
                                $player->addTitle(Main::Config("Success"), "§bRepaired Successful");
                            }
                        } else {
                            $player->sendMessage("§l§cYou dont have enough Money.");
                        }
                    }
                    if ($money >= $price) {
                        $EconomyAPI->reduceMoney($player, $price);
                        $player->getInventory()->setItem($slot, $Item->setDamage(0));
                        if (Main::Config("Send-Title-Success") === true) {
                            $player->addTitle(Main::Config("Success"), "§bRepaired Successful");
                        }
                    } else {
                        $player->sendMessage("§l§cYou dont have enough Money.");
                    }
                } else {
                    $player->getInventory()->setItem($slot, $Item->setDamage(0));
                    if (Main::Config("Send-Title-Success") === true) {
                        $player->addTitle(Main::Config("Success"), "§bRepaired Successful");
                    }
                }
            } else {
                $player->sendMessage("§l§4Sorry, Held Item Damage is Max, Repair Failed.");
            }
        }
        if (Main::Config("XP") === true) {
            $xp = $player->getXpLevel();
            $price = Main::Config("Repair-Item-Price-Xp");
            $enchantedPrice = Main::Config("Repair-Enchanted-Item-Price-Xp");
            $slot = $player->getInventory()->getHeldItemIndex();
            $Item = $player->getInventory()->getItem($slot);
            if ($Item->getDamage() > 0) {
                if (!$player->hasPermission("EasyRepairItems.command")) {
                    if (count($Item->getEnchantments()) !== 0) {
                        if ($xp >= $enchantedPrice) {
                            $reduce = $this->plugin->MinesXp($xp, $enchantedPrice);
                            $player->setXpLevel($reduce);
                            $player->getInventory()->setItem($slot, $Item->setDamage(0));
                            if (Main::Config("Send-Title-Success") === true) {
                                $player->addTitle(Main::Config("Success"), "§bRepaired Successful");
                            }
                        } else {
                            $player->sendMessage("§l§cYou dont have enough Xp.");
                        }
                    }
                    if ($xp >= $price) {
                        $reduce = $this->plugin->MinesXp($xp, $price);
                        $player->setXpLevel($reduce);
                        $player->getInventory()->setItem($slot, $Item->setDamage(0));
                        if (Main::Config("Send-Title-Success") === true) {
                            $player->addTitle(Main::Config("Success"), "§bRepaired Successful");
                        }
                    } else {
                        $player->sendMessage("§l§cYou dont have enough Xp.");
                    }
                } else {
                    $player->getInventory()->setItem($slot, $Item->setDamage(0));
                    if (Main::Config("Send-Title-Success") === true) {
                        $player->addTitle(Main::Config("Success"), "§bRepaired Successful");
                    }
                }
            } else {
                $player->sendMessage("§l§cYour Item Held Damage is Max!, Repair Failed.");
            }
        }
    }
}
