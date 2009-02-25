<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */

namespace Doctrine\ORM\Query\Parser;

/**
 * AbstractSchemaName ::= identifier
 *
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Janne Vanhala <jpvanhal@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        http://www.phpdoctrine.org
 * @since       2.0
 * @version     $Revision$
 */
class AbstractSchemaName extends \Doctrine\ORM\Query\ParserRule
{
    protected $_componentName = null;

    public function syntax()
    {
        // AbstractSchemaName ::= identifier
        $this->_parser->match(\Doctrine\ORM\Query\Token::T_IDENTIFIER);
        $this->_componentName = $this->_parser->token['value'];
    }

    public function semantical()
    {
        // Check if we are dealing with a real Doctrine_Entity or not
        if ( ! $this->_isDoctrineEntity($this->_componentName)) {
            $this->_parser->semanticalError(
                "Defined entity '" . $this->_componentName . "' is not a valid entity."
            );
        }

        // Return Component Name identifier
        return $this->_componentName;
    }
    
    protected function _isDoctrineEntity($componentName)
    {
        return class_exists($componentName);
    }
}