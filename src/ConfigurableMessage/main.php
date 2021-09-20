<?php

namespace ConfigurableMessage;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class main extends PluginBase{
    public function onEnable(){
       $this->getLogger()->info("Plugin enabled");
       $this->saveResource("message.yml");
       $this->MessageConfig = new Config($this->getDataFolder() . "message.yml", Config::YAML);
    }
    public $MessageConfig;
   public function getMessageConfig(){
        return $this->MessageConfig;
   }
    public function onLoad(){
       $this->getLogger()->info("Plugin loading");
    }
    public function onDisable(){
       $this->getLogger()->info("Plugin disabled");
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("ConfigurableMessage");
        if(!$sender instanceof Player) return false;
        switch (strtolower($cmd->getName())){
            case "announce":
                Server::getInstance()->broadcastMessage($plugin->getMessageConfig()->get("message"));
                if(!$sender->isOp()){
                    $sender->sendMessage(TextFormat::RED . "NO PERMISSION!");
                }
        }
        return false;
    }
}