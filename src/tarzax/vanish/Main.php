<?php

namespace tarzax\vanish;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(): void
    {
        $this->getLogger()->notice("TarzaxVanish has been successfully activated");
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        $commandname = $command->getName();
        if ($commandname = "vanish"){
            if($sender instanceof Player){
                if($sender->getEffects()->has(VanillaEffects::INVISIBILITY())){
                    $sender->getEffects()->remove(VanillaEffects::INVISIBILITY());
                    $sender->sendPopup($this->getConfig()->get("VanishPopupOff"));
                }else{
                    $effect = new EffectInstance(VanillaEffects::INVISIBILITY(), 60*100000, 1, false);
                    $sender->getEffects()->add($effect);
                    $sender->sendPopup($this->getConfig()->get("VanishPopupOn"));
                }
            }
        }
        return true;
    }
}
